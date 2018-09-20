<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Departement;
use App\Models\Region;
use App\Models\Commune;

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
        $departement = Departement::with('ftthdepartements')->with('region')->with('communes')->with('epci')->findOrFail($id);
        // print_r($departement->toArray());
        foreach($departement->ftthdepartements as $pourcent) {
            echo $pourcent->mavariable;
        }
        //exit;
        return response()->json(
            $departement    
        );
    }

    public function list() // Liste tous les départements
    {
            return response()->json(           
            $departement = Departement::all()->with('statdepartements')->sortBy('nom_departement') 
        );
    }

    public function geojson() // Récupère le geojson du contour des départements
    {
        return response(Storage::disk('public')->get('departements.geojson'))
                        ->header('Content-Type', 'text/plain');

    }

}
