<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StatRegion;
use App\Models\StatDepartement;


use Illuminate\Support\Facades\Storage;

class StatRegionController extends Controller
{     
      /**
     * 
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table statregions
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'une région
    {

        return response()->json(
           StatRegion::findOrFail($id)
        );
    }

    public function topshow(Request $request, $id) // Affiche le detail d'une région
    {
     
        return response()->json(
            $statregion = StatRegion::with('region')->where('pourcentage_progression', '>', 0)->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );    
    }
    public function list(Request $request) // Liste toutes les statregions 
    {
        return response()->json(
            $statregions = StatRegion::with('region')->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }
}

   