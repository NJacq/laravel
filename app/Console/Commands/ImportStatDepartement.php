<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use Illuminate\Support\Facades\Storage;
use App\Models\StatDepartement;
use App\Models\Departement;
use App\Models\FtthDepartement;

class ImportStatDepartement extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'import:statdepartements';

    /**
     * Description de la commande : imporer donnees depuis ftthdepartement.
     *
     * @var string
     */
    protected $description = 'Importer stats departements depuis ftthdepartements';

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
        $departements = Departement::all(); //Liste toutes les régions

        $periode = [ // tableau associatif
            3 => 2017,  // 3 = trimestre 3 = clé. 
            1 => 2018, //2018 = année 2018 = valeur
        ];
     
      
        foreach($departements as $departement) {  // On fait une boucle
            foreach($periode as $trimestre=>$annee) {
                $ftthdepartement = FtthDepartement::where('departement_id', $departement->id)->where('trimestre', $trimestre)->where('annee', $annee)->first();
                if(empty($ftthdepartement->id)) { // si ftthdepartements n'a pas id departements
                    $this->error('Impossible de trouver le trimestre '.$trimestre.' de année '.$annee.' pour la région '.$departement->nom_departement);
                } else {
                    $this->info('Pour la région '.$departement->nom_departement.' le trimestre '.$trimestre.' '.$annee.' a '.$ftthdepartement->nombre_locaux.' locaux raccordables.');
                    $locauxTrimestre[$trimestre.'-'.$annee] = $ftthdepartement;
             
                }           
            }   
     
            $trimestre_debut = key($periode);       
            $annee_debut = $periode[key($periode)];
            $trimestre_fin = $trimestre;
            $annee_fin = $annee;
            $nb_locaux_debut = $locauxTrimestre[$trimestre_debut.'-'.$annee_debut]->nombre_locaux;  
            $nb_locaux_fin = $locauxTrimestre[$trimestre_fin.'-'.$annee_fin]->nombre_locaux;

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
            // $this->line('===> Département '.$departement->nom_departement.' : T3-2017 = '.$nb_locaux_debut.' / T1-2018 = '.$nb_locaux_fin);
        
                  
            
            $dataToInsert = [
                'departement_id' => $departement->id,
                'region_id' => $departement->region_id,
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
            $newStatDepartement = StatDepartement::updateOrCreate([ // fonction qui permet d'ajouter ou de modifier des éléments à la base de données
                'departement_id' => $dataToInsert['departement_id'] // On se base sur la clé 'departement_id" pour véfifier les modifications des autres clés. 
            ], $dataToInsert);    

        }

        $this->info('Fin du script');
    }
}
