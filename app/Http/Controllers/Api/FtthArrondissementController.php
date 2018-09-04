<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthArrondissement;

use Illuminate\Support\Facades\Storage;

class FtthArrondissementController extends Controller
{     
      /**
     * Show the profile for the given arrondissement.
     *
     * @param  int  $id Identifiant de la ligne dans la table fttharrondissements
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un arrondissement
    {

        return response()->json(
            FtthArrondissement::findOrFail($id)
        );
    }

    public function list() // Liste tous les arrondissements
    {

        return response()->json(
            FtthArrondissement::all()
        );
    }
}

   