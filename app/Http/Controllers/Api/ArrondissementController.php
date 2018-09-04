<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Arrondissement;
use App\Models\Commune;


use Illuminate\Support\Facades\Storage;

class ArrondissementController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  int  $id Identifiant de la ligne dans la table arrondissents
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un arrondissement
    {
    
        return response()->json(
            Arrondissement::with('commune')->with('fttharrondissements')->findOrFail($id)
        );
    }

    public function list() // Liste tous les arrondissements
        {
        
        return response()->json(
            Arrondissement::all()
        );
    }
}
