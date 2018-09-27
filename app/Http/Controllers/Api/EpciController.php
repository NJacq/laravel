<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Epci;
use App\Models\Departement;
use App\Models\Commune;


use Illuminate\Support\Facades\Storage;

class EpciController extends Controller
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
            Epci::with('departement')->with('communes')->with('ftthepci')->with('ftthcommune')->with('statcommune')->orderBy('nom_epci')->findOrFail($id)
        );
    }

    public function list() // Liste toutes les communes
        {
        
        return response()->json(
            Epci::orderBy('nom_epci')->get()
        );
    }
}
