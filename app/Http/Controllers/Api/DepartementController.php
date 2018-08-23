<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Departement;

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
        /*
        return view('departement.show', [
            'departement' => Departement::findOrFail($id),
            'title' => 'Détail du département :'
        ]);
        */ 
        return response()->json(
            Departement::findOrFail($id)
        );
    }

    public function list() // Liste tous les départements
    {
        /*
        return view('departement.list',[
            'departements' => Departement::all()         
        ]);
        */
        return response()->json(
            Departement::all()
        );
    }

    public function geojson() // Récupère le geojson du contour des départements
    {
        return response(Storage::disk('public')->get('departements.geojson'))
                        ->header('Content-Type', 'text/plain');

    }

}