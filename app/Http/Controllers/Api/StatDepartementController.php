<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StatDepartement;
use App\Models\Region;

use Illuminate\Support\Facades\Storage;

class StatDepartementController extends Controller
{     
      /**
     * 
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table statDepartements
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un departement
    {
        $region = Region::findOrFail($id);
        // echo($region);
        return response()->json(

            $statdepartements = StatDepartement::with('region')->with('departement')->where('region_id', $region->id)->where('pourcentage_progression', '>', 0)->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }

    public function list(Request $request) // Liste toutes les statdepartements
    {
        return response()->json(
            $statdepartements = StatDepartement::with('departements')->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }
}

   