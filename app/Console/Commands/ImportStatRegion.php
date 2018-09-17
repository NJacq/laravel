<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\StatRegion;
use App\Models\Region;
use App\Models\FtthRegion;

class ImportStatRegion extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:statregions';

    /**
     * Description de la commande : imporer un fichier csv.
     *
     * @var string
     */
    protected $description = 'Importer stats regions depuis ftthregions';

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
        $regions = Region::all(); //Liste toutes les régions

        $periode = [ // tableau associatif
            3 => 2017,  // 3 = trimestre 3 = clé. 
            1 => 2018, //2018 = année 2018 = valeur
        ];
      
        foreach($regions as $region) {  // On fait une boucle
            foreach($periode as $trimestre=>$annee) {
                $ftthregion = FtthRegion::where('region_id', $region->id)->where('trimestre', $trimestre)->where('annee', $annee)->first();
                if(empty($ftthregion->id)) { // si ftthregions n'a pas id regions
                    $this->error('Impossible de trouver le trimestre '.$trimestre.' de année '.$annee.' pour la région '.$region->nom_region);
                } else {
                    $this->info('Pour la région '.$region->nom_region.' le trimestre '.$trimestre.' '.$annee.' a '.$ftthregion->nombre_locaux.' locaux raccordables.');
                    $locauxTrimestre[$trimestre.'-'.$annee] = $ftthregion;
                  
                }           
            }   
            
            if ($locauxTrimestre['3-2017']->nombre_locaux === 0){ // si nombre de locaux au 3è trimestre 2017 est égal à 0 alors erreur
                $this->error('Impossible de diviser par 0');
            } else {
                $pourcentage = ($locauxTrimestre['1-2018']->nombre_locaux - $locauxTrimestre['3-2017']->nombre_locaux)/$locauxTrimestre['3-2017']->nombre_locaux*100; //Calcul du pourcentage d'augmentation du nombre de locaux entre le 3è trimestre 2017 et le 1er trimestre 2018
                $this->info('Le nombre de locaux a augmenté de '.$pourcentage.'%');    
            }
            $this->line('===> Région '.$region->nom_region.' : T3-2017 = '.$locauxTrimestre['3-2017']->nombre_locaux.' / T1-2018 = '.$locauxTrimestre['1-2018']->nombre_locaux);
        
       
            
            $trimestre_debut = 3;
            $annee_debut = 2017;
            $trimestre_fin = $trimestre;
            $annee_fin = $annee;
            $nb_locaux_debut = $locauxTrimestre['3-2017']->nombre_locaux;
            $nb_locaux_fin = $locauxTrimestre['1-2018']->nombre_locaux;

            $dataToInsert = [
                'region_id' => $region->id,
                'trimestre_debut' => $trimestre_debut,
                'annee_debut' => $annee_debut,
                'trimestre_fin' => $trimestre_fin,
                'annee_fin' => $annee_fin,
                'nb_locaux_debut' => $nb_locaux_debut,
                'nb_locaux_fin' => $nb_locaux_fin,
                'pourcentage_progression' => $pourcentage,
            ];
            print_r($dataToInsert);

            $newStatRegion = StatRegion::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                'region_id' => $dataToInsert['region_id'] // On se base sur la clé 'code_region" pour véfifier les modifications des autres clés. 
            ], $dataToInsert);    

        }

        $this->info('Fin du script');
    }
}
