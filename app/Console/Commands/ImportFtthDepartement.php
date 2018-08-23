<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\FtthDepartement;

class ImportFtthDepartement extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:ftthdepartements {file}';

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
                    'trimestre' => 'T3',
                    'annee' => 2017,
                ],
                3 => [
                    'trimestre' => 'T4',
                    'annee' => 2017,
                ],
                4 => [
                    'trimestre' => 'T1',
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
                            $datasForOneDepartement[$j] = [
                                'code_departement' => $row[0],
                                'nombre_locaux' => $row[$j],
                                'trimestre' => $trimestres[$j]['trimestre'],
                                'annee' => $trimestres[$j]['annee'],
                            ];
                        }
                        //print_r($datasForOneDepartement); // ici, le tableau data à bien 3 entrées pour 3 trimestres
                        continue; // on passe à la ligne suivante qui correspond aux catégories des trimestres de cette ligne

                    }

                    // c'est une ligne catégorie => on doit compléter le tableau "data" créé à la précédente ligne
                    if($row[1]=='Catégorie') {
                        // ici on a $data
                        for($j=2;$j<5;$j++) { // on parcours les 3 colonnes de catégorie
                            $datasForOneDepartement[$j]['categorie'] = $row[$j];
                        }
                        print_r($datasForOneDepartement);
                        

                        // on parcours ce tableau data pour insérer 3 lignes = 3 trimestres
                        foreach($datasForOneDepartement as $lineForThisDepartement) {
                            //print_r($lineForThisDepartement);
                            //exit;
                            FtthDepartement::updateOrCreate([
                                'code_departement' => $lineForThisDepartement['code_departement'],
                                'trimestre' => $lineForThisDepartement['trimestre'],
                                'annee' => $lineForThisDepartement['annee'],
                            ],$lineForThisDepartement);
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

