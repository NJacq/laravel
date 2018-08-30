<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthDepartement;

use Illuminate\Support\Facades\Storage;

class FtthDepartementController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  int  $id Identifiant de la ligne dans la table departemernts
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un département
    {

        return response()->json(
            FtthDepartement::findOrFail($id)
        );
    }

    public function list() // Liste tous les départements
    {

        return response()->json(
            FtthDepartement::all()
        );
    }
}

   