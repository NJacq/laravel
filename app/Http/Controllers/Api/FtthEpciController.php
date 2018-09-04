<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthEpci;

use Illuminate\Support\Facades\Storage;

class FtthEpciController extends Controller
{     
      /**
     * Show the profile for the given epci.
     *
     * @param  int  $id Identifiant de la ligne dans la table epci
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un epci
    {

        return response()->json(
            FtthEpci::with('communes')->findOrFail($id)
        );
    }

    public function list() // Liste tous les epci
    {

        return response()->json(
            FtthEpci::with('communes')->all()
        );
    }
}

   