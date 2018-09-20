<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StatEpci;
use App\Models\Departement;

use Illuminate\Support\Facades\Storage;

class StatEpciController extends Controller
{     
      /**
     * 
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table statEpcis
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un epci
    {
        $departement = Departement::findOrFail($id);
        // echo($region);
        return response()->json(

            $statepci = StatEpci::with('epci')->with('departement')->where('departement_id', $departement->id)->where('pourcentage_progression', '>', 0)->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }

    // public function list(Request $request) // Liste toutes les statdepartements
    // {
    //     return response()->json(
    //         $statdepartements = StatDepartement::with('departements')->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
    //     );
    // }
}

   