<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Arrondissement;
use App\Models\Departement;
use App\Models\Commune;


use Illuminate\Support\Facades\Storage;

class CommuneController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  int  $id Identifiant de la ligne dans la table departemernts
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'une commune
    {
    
        return response()->json(
            Commune::with('departement')->with('ftthCommunes')->with('arrondissements')->with('epci')->findOrFail($id)
        );
    }

    public function list() // Liste toutes les communes
        {
        
        return response()->json(
            Commune::all()
        );
    }

    public function search(Request $request) // Liste toutes les communes pour la recherche
        {
                
        return response()->json(            
            //Commune::where('nom_commune', 'like', '%'.$request->q.'%')->get()->pluck('nom_commune', 'id')
            Commune::where('nom_commune', 'like', '%'.$request->q.'%')->get()
        );
    }
}
