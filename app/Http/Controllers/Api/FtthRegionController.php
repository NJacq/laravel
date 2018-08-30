<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthRegion;

use Illuminate\Support\Facades\Storage;

class FtthRegionController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  int  $id Identifiant de la ligne dans la table ftthregions
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'une région
    {

        return response()->json(
            FtthRegion::findOrFail($id)
        );
    }

    public function list() // Liste toutes les régions
    {

        return response()->json(
            FtthRegion::all()
        );
    }
}

   