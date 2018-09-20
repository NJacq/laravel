<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StatCommune;
use App\Models\Departement;
use App\Models\Epci;

use Illuminate\Support\Facades\Storage;

class StatCommuneController extends Controller
{     
      /**
     * 
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table statCommunes
     * @return Response
     */
    
    public function showdepartement($id) // Affiche le detail d'une commune d'un departement
    {
        $departement = Departement::findOrFail($id);
        return response()->json(
            $statcommunes = StatCommune::with('departement')->with('commune')->where('departement_id', $departement->id)->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }

    public function showepci($id) // Affiche le detail d'une commune d'un epci
    {
        $epci = Epci::findOrFail($id);
        return response()->json(
            $statcommunes = StatCommune::with('epci')->with('commune')->where('epci_id', $epci->id)->where('pourcentage_progression', '>', 0)->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }



    public function list(Request $request) // Liste toutes les statcommunes
    {
        return response()->json(
            $statcommunes = StatCommune::with('departements')->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }
}

   