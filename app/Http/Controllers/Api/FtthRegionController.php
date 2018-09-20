<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthRegion;
use App\Models\FtthDepartement;
use App\Models\Region;

use Illuminate\Support\Facades\Storage;

class FtthRegionController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table ftthregions
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'une région
    {

        return response()->json(
            FtthRegion::findOrFail($id)
        );
    }    

    public function topshow(Request $request, $id) // Affiche le top ftth du dernier trimestre d'une region
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;
        $region = Region::findOrFail($id);
        return response()->json(
            $ftthtopdepartements = FtthDepartement::where('region_id', $region->id)->where('trimestre', 1)->where('annee', 2018)->with('departement')->orderBy('categorie', 'desc')->limit(5)->get()
        );    
    }

    public function list(Request $request) // Liste toutes les ftthrégions du dernier trimestre
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;
        
        return response()->json(
            $ftth = FtthRegion::with('region')->where('trimestre', '=', $trimestre)->where('annee','=', $annee)->where('categorie', '>', 0)->orderBy('categorie', 'desc')->limit(5)->get()
        );
    }
}

   