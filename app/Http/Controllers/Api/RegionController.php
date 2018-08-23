<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Region;

use Illuminate\Support\Facades\Storage;

class RegionController extends Controller
{     
      /**
     * 
     *
     * @param  int  $id Identifiant de la ligne dans la table regions
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'une région
    {
            return response()->json(
            Region::findOrFail($id)
        );
    }

    public function list() // Liste toutes les régions
    {
            return response()->json(
            Region::all()
        );
    }
}
