<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\StatCommune;
use App\Models\Departement;
use App\Models\Epci;
use App\Models\FtthCommune;
use App\Models\Commune;

class ImportStatCommune extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:statcommunes';

    /**
     * Description de la commande : imporer donnees depuis ftthcommunes.
     *
     * @var string
     */
    protected $description = 'Importer stats communes depuis ftthcommunes';

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
        $communes = Commune::all(); //Liste toutes les régions

        $periode = [ // tableau associatif
            3 => 2017,  // 3 = trimestre 3 = clé. 
            1 => 2018, //2018 = année 2018 = valeur
        ];
     
      
        foreach($communes as $commune) {  // On fait une boucle
            foreach($periode as $trimestre=>$annee) {
                $ftthcommunes = FtthCommune::where('commune_id', $commune->id)->where('trimestre', $trimestre)->where('annee', $annee)->first();
                if(empty($ftthcommunes->id)) { 
                    $this->error('Impossible de trouver le trimestre '.$trimestre.' de année '.$annee.' pour la commune '.$commune->nom_commune);
                } else {
                    $this->info('Pour la commune '.$commune->nom_commune.' le trimestre '.$trimestre.' '.$annee.' a '.$ftthcommunes->locaux_raccordables.' locaux raccordables.');
                    $locauxTrimestre[$trimestre.'-'.$annee] = $ftthcommunes;
             
                }           
            }   
     
            $trimestre_debut = key($periode);       
            $annee_debut = $periode[key($periode)];
            $trimestre_fin = $trimestre;
            $annee_fin = $annee;
            $nb_locaux_debut = $locauxTrimestre[$trimestre_debut.'-'.$annee_debut]->locaux_raccordables;  
            $nb_locaux_fin = $locauxTrimestre[$trimestre_fin.'-'.$annee_fin]->locaux_raccordables;

            $pourcentage = null;

            if($nb_locaux_debut>0 && $nb_locaux_fin>0 && ($nb_locaux_debut < $nb_locaux_fin)) {
                $pourcentage = round(($nb_locaux_fin - $nb_locaux_debut)/$nb_locaux_debut*100); //Calcul du pourcentage d'augmentation du nombre de locaux entre le 3è trimestre 2017 et le 1er trimestre 2018
                $this->info('Le nombre de locaux a augmenté de '.$pourcentage.'%');
            }

            /*
            if ($nb_locaux_debut === 0){ // si nombre de locaux au 3è trimestre 2017 est égal à 0 alors erreur
                $this->error('Impossible de diviser par 0');
                $pourcentage = '';
            } else {
                $pourcentage = ($nb_locaux_fin - $nb_locaux_debut)/$nb_locaux_debut*100; //Calcul du pourcentage d'augmentation du nombre de locaux entre le 3è trimestre 2017 et le 1er trimestre 2018
                $this->info('Le nombre de locaux a augmenté de '.$pourcentage.'%');    
            }
            */
            $this->line('===> Commune '.$commune->nom_commune.' : T3-2017 = '.$nb_locaux_debut.' / T1-2018 = '.$nb_locaux_fin);
            
            
            $dataToInsert = [
                'commune_id' => $commune->id,
                'epci_id' => $commune->epci_id,
                'departement_id' => $commune->departement_id,
                'trimestre_debut' => $trimestre_debut,
                'annee_debut' => $annee_debut,
                'trimestre_fin' => $trimestre_fin,
                'annee_fin' => $annee_fin,
                'nb_locaux_debut' => $nb_locaux_debut,
                'nb_locaux_fin' => $nb_locaux_fin,
                'pourcentage_progression' => $pourcentage,
            ];
            print_r($dataToInsert);
    //    exit;
            $newStatDepartement = StatCommune::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
            'commune_id' => $dataToInsert['commune_id'] // On se base sur la clé 'departement_id" pour véfifier les modifications des autres clés. 
            ], $dataToInsert);    
            
        }

        $this->info('Fin du script');
    }
}
