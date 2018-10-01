<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;

use App\Models\AjoutRegion;
use App\Models\Region;


class ImportAjoutRegion extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:ajoutregions';

    /**
     * Description de la commande : imporer des regions non presentes dans le csv.
     *
     * @var string
     */
    protected $description = 'Importer régions non présentes';

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
       
        $regions= [
            '05' => 'Saint-Pierre-Et-Miquelon',
            '07' => 'Saint-Barthélemy',
            '08' => 'Saint-Martin',
        ];
        // print_r($urlCarte);
      print_r($regions);
        foreach($regions as $code=>$nom)
            {          

            $dataToInsert = [ // Creation d'un tableau avec la même structure que la base de données
                'code_region' => $code,
                'nom_region' => $nom,
                
            ];
            print_r($dataToInsert);
            // exit;
            
            $newRegion = Region::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                'code_region' => $dataToInsert['code_region'] // On se base sur la clé 'code_region" pour véfifier les modifications des autres clés. 
            ], $dataToInsert);
        };  

        $this->info('Fin du script');
    }
}
