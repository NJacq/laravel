<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Departement;
use App\Models\Region;
use App\Models\Commune;
use App\Models\Epci;


use Illuminate\Support\Facades\Storage;

class DepartementController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  int  $id Identifiant de la ligne dans la table departemernts
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un département
    {
        $departement = Departement::with('ftthdepartements')->with('urlcartedepartement')->with('region')->with('communes')->with('epci')->orderBy('nom_departement')->findOrFail($id);
        // print_r($departement->toArray());
        foreach($departement->ftthdepartements as $pourcent) {
            echo $pourcent->mavariable;
        }
        //exit;
        return response()->json(
            $departement    
        );
    }

    public function showepci($id) // Affiche les epci d'un departement
    {
        $epci = Epci::where('departement_id', $id)->orderBy('nom_epci')->get();        
        return response()->json(
            $epci
        );
    }

    public function list() // Liste tous les départements
    {
            return response()->json(           
            $departement = Departement::with('statdepartements')->orderBy('nom_departement')->get() 
        );
    }  

}
