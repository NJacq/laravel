<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;

use App\Models\Arrondissement;
use App\Models\Commune;

class ImportArrondissement extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:arrondissements {file}';

    /**
     * Description de la commande : imporer un fichier csv.
     *
     * @var string
     */
    protected $description = 'Importer les arrondissements depuis le fichier csv arcep';

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
            foreach($reader->getSheetIterator() as $sheet) { // parcourir les feuilles; une seule pour un csv 
                $i = 0;

                foreach($sheet->getRowIterator() as $row) {
                    $i++;
                    if($i<6) {
                        continue; // On ne prend pas en compte les lignes 1 à 5                            
                    }
                    // print_r($row); // Le résultat obtenu apparait sous la forme d'un tableau  

                    $name = ['2e', '3e', '4e', '5e', '6e', '7e', '8e', '9e', '10e', '11e', '12e', '13e', '14e', '15e', '16e', '17e', '18e', '19e', '20e'];
                    $newName = ['2ème', '3ème', '4ème', '4ème', '5ème', '6ème', '7ème', '8ème', '9ème', '10ème', '11ème', '12ème', '13ème', '14ème', '15ème', '16ème', '17ème', '18ème', '19ème', '20ème'];

                    $dataToInsert = [ // Creation d'un tableau avec la même structure que la base de données
                        'code_arrondissement' => $row[0],
                        'nom_arrondissement' => str_replace($name, $newName, $row[1]),
                        'code_region' => $row[2],
                        'code_departement' => $row[3],
                        'siren_epci' => (int)str_replace('ZZZZZZZZZ','',$row[4]),
                        'code_commune' => $row[5],
                        'logements' => (int)str_replace(' ','',$row[6]),
                        'etablissements' => (int)str_replace(' ','',$row[7]),
                        'zones_td' => $row[8],                       
                        'oi_2018_t1' => $row[9]
                    ];

                    
                    $commune = Commune::where('code_commune', $dataToInsert['code_commune'])->first();

                    if(empty($commune->id)) {
                        $this->error('Impossible de trouver l\'arrondissement '.$dataToInsert['code_commune'].' pour la commune '.$dataToInsert['code_arrondissement']);
               
                    } else {
                        $dataToInsert['commune_id'] = $commune->id;
                    }
                    
                    $newArrondissement = Arrondissement::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                        'code_arrondissement' => $dataToInsert['code_arrondissement'] // On se base sur la clé 'code_departement" pour véfifier les modifications des autres clés. 
                    ], $dataToInsert);    
                    
                } 
            }            
        } else {
            $this->error('le fichier n\'existe pas');
        }
 
        $this->info('Fin du script');
    }
}
