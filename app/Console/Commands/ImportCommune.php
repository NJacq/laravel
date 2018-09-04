<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;

use App\Models\Departement;
use App\Models\Commune;
use App\Models\Epci;

class ImportCommune extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:commune {file}';

    /**
     * Description de la commande : imporer un fichier csv.
     *
     * @var string
     */
    protected $description = 'Importer les communes depuis le fichier csv arcep';

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
                        'code_commune' => $row[0],
                        'nom_commune' => $row[1],
                        'code_region' => $row[2],
                        'code_departement' => $row[3],
                        'siren_epci' => (int)str_replace('ZZZZZZZZZ','',$row[4]),
                        'logements' => (int)str_replace(' ','',$row[5]),
                        'etablissements' => (int)str_replace(' ','',$row[6]),
                        'zones_td' => $row[7],
                        'engagements' => $row[8],
                        'hors_engagements' => $row[9],
                        'commune_rurale' => $row[10],
                        'commune_montagne' => $row[11],
                        'oi_2018_t1' => $row[12]
                    ];

                    
                    $departement = Departement::where('code_departement', $dataToInsert['code_departement'])->first();
                    $epci = Epci::where('siren_epci', $dataToInsert['siren_epci'])->first();

                    if(empty($departement->id)) {
                        $this->error('Impossible de trouver le département '.$dataToInsert['code_departement'].' pour la commune '.$dataToInsert['code_commune']);
                   
                    }
                    if(empty($epci->id)) {
                        $this->error('Impossible de trouver l\'epci '.$dataToInsert['siren_epci'].' pour la commune '.$dataToInsert['code_commune']);
                 
                    }

                    $dataToInsert['departement_id'] = $departement->id;
                    $dataToInsert['epci_id'] = $epci->id;
                    $newCommune = Commune::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                        'code_commune' => $dataToInsert['code_commune'] // On se base sur la clé 'code_departement" pour véfifier les modifications des autres clés. 
                    ], $dataToInsert);    
                    
                } 
            }            
        } else {
            $this->error('le fichier n\'existe pas');
        }
 
        $this->info('Fin du script');
    }
}
