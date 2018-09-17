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

    public function topshow(Request $request, $id) // Affiche le detail d'une région
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;
        return response()->json(
            $ftth = FtthRegion::with('region')->with('ftthdepartements')->with('departement')->where('trimestre', '=', $trimestre)->where('annee','=', $annee)->orderBy('categorie', 'desc')->limit(5)->findOrFail()->get()
        );    
    }

    public function list(Request $request) // Liste toutes les ftthrégions du dernier trimestre
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;

        return response()->json(
            $ftth = FtthRegion::with('region')->where('trimestre', '=', $trimestre)->where('annee','=', $annee)->orderBy('categorie', 'desc')->limit(5)->get()
        );
    }
}

   