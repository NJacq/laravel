<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\FtthRegion;
use App\Models\Region;

class ImportFtthRegion extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:ftthregions {file}';

    /**
     * Description de la commande : imporer un fichier csv.
     *
     * @var string
     */
    protected $description = 'Importer fichier csv arcep';

    /**
     * Créer une nouvelle instance de commande.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Exécuter la commande
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Début du script');

        $i = 0; 
        $fileName = $this->argument('file');

        $this->info('Importation du fichier : '.$fileName);

        $exists = Storage::disk('public')->exists($fileName);
        
        if ($exists) { // on vérifie que le fichier que l'on veut importer existe
            
            $fileNameAbsolutePath = Storage::disk('public')->path($fileName);

            $this->info('Le fichier est dans : '.$fileNameAbsolutePath);
                    
            $reader = ReaderFactory::create(Type::CSV); //on utilise box/spout pour lire le fichier
            $reader->setFieldDelimiter(',');
            $reader->open($fileNameAbsolutePath); // ouvrir le fichier csv            
            
            $trimestres = [
                2 => [
                    'trimestre' => '3',
                    'annee' => 2017,
                ],
                3 => [
                    'trimestre' => '4',
                    'annee' => 2017,
                ],
                4 => [
                    'trimestre' => '1',
                    'annee' => 2018,
                ],
            ];
            
            foreach($reader->getSheetIterator() as $sheet) { // parcourir les feuilles; une seule pour un csv 
                
                $i = 0;

                foreach($sheet->getRowIterator() as $row) {
                
                    $i++;

                    if($i<6) {
                        continue; // On ne prend pas en compte les lignes 1 à 5                            
                    }

                    // si c'est une ligne locaux raccordables
                    if($row[1]=='Locaux Raccordables') {

                        for($j=2;$j<5;$j++) { // on parcours les 3 dernières colonnes de cette ligne = elles correspondent aux trimestres
                            $datasForOneRegion[$j] = [
                                'code_region' => $row[0],
                                'nombre_locaux' => $row[$j],
                                'trimestre' => $trimestres[$j]['trimestre'],
                                'annee' => $trimestres[$j]['annee'],
                            ];
                        }
                        //print_r($datasForOneRegion); // ici, le tableau data à bien 3 entrées pour 3 trimestres
                        continue; // on passe à la ligne suivante qui correspond aux catégories des trimestres de cette ligne

                    }

                    // c'est une ligne catégorie => on doit compléter le tableau "data" créé à la précédente ligne
                    if($row[1]=='Catégorie') {
                        // ici on a $data
                        for($j=2;$j<5;$j++) { // on parcours les 3 colonnes de catégorie
                            $datasForOneRegion[$j]['categorie'] = $row[$j];
                        }
                        continue;
                    }
                    if($row[1]=='Au moins un opérateur au PM via la mutualisation passive') {
                        // ici on a $data
                        for($j=2;$j<5;$j++) { // on parcours les 3 colonnes de catégorie
                            $datasForOneRegion[$j]['unoperateur'] = $row[$j];
                        }
                        continue;
                    }
                    if($row[1]=='Au moins deux opérateurs au PM via la mutualisation passive') {
                        // ici on a $data
                        for($j=2;$j<5;$j++) { // on parcours jes 3 cojonnes de catégorie
                            $datasForOneRegion[$j]['deuxoperateurs'] = $row[$j];
                        }  
                        continue;
                    }
                    if($row[1]=='Au moins trois opérateurs au PM via la mutualisation passive') {
                        // ici on a $data
                        for($j=2;$j<5;$j++) { // on parcours les 3 colonnes de catégorie
                            $datasForOneRegion[$j]['troisoperateurs'] = $row[$j];
                        }
                        continue;
                    }
                    if($row[1]=='Au moins quatre opérateurs au PM via la mutualisation passive') {
                        // ici on a $data
                        for($j=2;$j<5;$j++) { // on parcours les 3 colonnes de catégorie
                            $datasForOneRegion[$j]['quatreoperateurs'] = $row[$j];
                        }
                        print_r($datasForOneRegion);
                        

                        // on parcours ce tableau data pour insérer 3 lignes = 3 trimestres
                        foreach($datasForOneRegion as $lineForThisRegion) {                            
                            // print_r($lineForThisRegion);
                            // exit;
                            $region = Region::where('code_region', $lineForThisRegion['code_region'])->first();

                            if(empty($region->id)) {
                                $this->error('Impossible de trouver la région '.$lineForThisRegion['code_region'].' pour le département '.$lineForThisRegion['code_departement']);
                                // exit;
                            }
            
                            $lineForThisRegion['region_id'] = $region->id;                                
                            FtthRegion::updateOrCreate([
                                'code_region' => $lineForThisRegion['code_region'],
                                'trimestre' => $lineForThisRegion['trimestre'],
                                'annee' => $lineForThisRegion['annee'],
                            ],$lineForThisRegion);
                        }
                    }                     
                }  
            }            
        } else {
            $this->error('le fichier n\'existe pas');
        }
 
        $this->info('Fin du script');
    }
}

