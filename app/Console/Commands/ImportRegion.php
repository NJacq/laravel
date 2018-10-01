<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\Region;

class ImportRegion extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:regions {file}';

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
            foreach($reader->getSheetIterator() as $sheet) { // parcourir les feuilles; une seule pour un csv 
                $i = 0;

                foreach($sheet->getRowIterator() as $row) {
                    $i++;
                    if($i<6) {
                        continue; // On ne prend pas en compte les lignes 1 à 5                            
                    }
                    // print_r($row); // Le résultat obtenu apparait sous la forme d'un tableau  

                    $dataToInsert = [ // Creation d'un tableau avec la même structure que la base de données
                        'code_region' => $row[0],
                        'nom_region' => $row[1],
                        'logements' => (int)str_replace(' ','',$row[2]),
                        'etablissements' => (int)str_replace(' ','',$row[3])
                    ];
                    // print_r($dataToInsert); 
                    
                    $newRegion = Region::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                        'code_region' => $dataToInsert['code_region'] // On se base sur la clé 'code_region" pour véfifier les modifications des autres clés. 
                    ], $dataToInsert);    
                    
                } 
            }            
        } else {
            $this->error('le fichier n\'existe pas');
        }
 
        $this->info('Fin du script');
    }
}
