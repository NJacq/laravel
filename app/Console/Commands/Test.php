<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Departements;

class Import extends Command
{
    /**
     * Indique le nom de la commande dans php artisan.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * Description de la commande : imporer un fichier csv.
     *
     * @var string
     */
    protected $description = 'tester des trucs';

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
 
        
        // $departement = new Departements; // nouveau modèle départrement

        // les valeurs de ce nouveaux modèles
        // $departements->code_departement = '25'.uniqid();
        // $departements->nom_departement = 'doubs'.uniqid();
        // $departements->code_region = 'bfc'.uniqid();

        // $departements->save(); // on sauvegarde
        

        // $departements = Departements::all();

        // foreach ($departements as $departement) 
        // {
        //     $this->line($departement->code_departement);
        // }

        $departement = Departements::where('nom_departement', 'doubs')
        ->orderby('id')
        ->first();
        $this->line($departement->nom_departement);
      

        /*
        $departements->nom_departement = 'testtest';
        $departements->save();
        
        
        $departement = Departements::find(2);
        $this->line($departement->nom_departement);

        $departement->nom_departement = 'doubs';
        $departement->save();
        

        $this->line('maintenant je suis '.$departement->nom_departement);
        */
        
        //Departements::destroy(1);
        
        $this->info('Fin du script');

    }
}
