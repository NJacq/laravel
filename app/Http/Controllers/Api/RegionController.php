<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Region;
use App\Models\Departement;

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
        
        $region = Region::with('ftthregions')->with('departements')->with('statdepartements')->findOrFail($id);
        // print_r($region->toArray());
        foreach($region->ftthregions as $pourcent) {
            echo $pourcent->mavariable;
        }
        // exit;
        return response()->json(
            $region
        );
    }
    public function showdepartements($id) // Affiche les départements d'une région
    {
        $departements = Departement::where('region_id', $id)->orderBy('nom_departement')->get();        
        return response()->json(
            $departements
        );
    }

    public function list() // Liste toutes les régions
    {
        $region = Region::orderBy('nom_region')->with('statregions')->get();        
        return response()->json(
            $region
        );        
    }    
}
