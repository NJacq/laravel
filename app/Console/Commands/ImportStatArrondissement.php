<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\StatArrondissement;
use App\Models\Commune;
use App\Models\FtthArrondissement;
use App\Models\Arrondissement;

class ImportStatArrondissement extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:statarrondissements';

    /**
     * Description de la commande : imporer donnees depuis fttharrondissements.
     *
     * @var string
     */
    protected $description = 'Importer stats arrondissements depuis fttharrondissements';

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
        $arrondissements = Arrondissement::all(); //Liste tous les arrondissements

        $periode = [ // tableau associatif
            3 => 2017,  // 3 = trimestre 3 = clé. 
            1 => 2018, //2018 = année 2018 = valeur
        ];
     
      
        foreach($arrondissements as $arrondissement) {  // On fait une boucle
            foreach($periode as $trimestre=>$annee) {
                $fttharrondissement = FtthArrondissement::where('arrondissement_id', $arrondissement->id)->where('trimestre', $trimestre)->where('annee', $annee)->first();
                if(empty($fttharrondissement->id)) { 
                    $this->error('Impossible de trouver le trimestre '.$trimestre.' de année '.$annee.' pour la région '.$arrondissement->nom_arrondissement);
                } else {
                    $this->info('Pour l\' arrondissement '.$arrondissement->nom_arrondissement.' le trimestre '.$trimestre.' '.$annee.' a '.$fttharrondissement->locaux_raccordables.' locaux raccordables.');
                    $locauxTrimestre[$trimestre.'-'.$annee] = $fttharrondissement;
             
                }           
            }   

            // exit;
     
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
            
            // if ($nb_locaux_debut === 0){ // si nombre de locaux au 3è trimestre 2017 est égal à 0 alors erreur
            //     $this->error('Impossible de diviser par 0');
            //     $pourcentage = '0';
            // } else {
            //     $pourcentage = ($nb_locaux_fin - $nb_locaux_debut)/$nb_locaux_debut*100; //Calcul du pourcentage d'augmentation du nombre de locaux entre le 3è trimestre 2017 et le 1er trimestre 2018
            //     $this->info('Le nombre de locaux a augmenté de '.$pourcentage.'%');    
            // }
            // $this->line('===> Arrondissement '.$arrondissement->nom_arrondissement.' : T3-2017 = '.$nb_locaux_debut.' / T1-2018 = '.$nb_locaux_fin);
        
                  
            
            $dataToInsert = [
                'arrondissement_id' => $arrondissement->id,
                'commune_id' => $arrondissement->commune_id,
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
            StatArrondissement::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                'arrondissement_id' => $dataToInsert['arrondissement_id'] // On se base sur la clé 'departement_id" pour véfifier les modifications des autres clés. 
            ], $dataToInsert);    

        }

        $this->info('Fin du script');
    }
}
