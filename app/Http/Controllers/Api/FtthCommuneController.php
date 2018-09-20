<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthCommune;
use App\Models\FtthArrondissement;
use App\Models\Commune;

use Illuminate\Support\Facades\Storage;

class FtthCommuneController extends Controller
{     
      /**
     * Show the profile for the given communet.
     *
     * @param  int  $id Identifiant de la ligne dans la table departemernts
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'une commune
    {

        return response()->json(
            FtthCommune::findOrFail($id)
        );
    }

    public function topshowarrondissements(Request $request, $id) // Affiche le top ftth du dernier trimestre d'un departement
    {
        $commune = Commune::findOrFail($id);
        return response()->json(
            $ftthtoparrondissements = FtthArrondissement::where('commune_id', $commune->id)->where('trimestre', 1)->where('annee', 2018)->where('categorie', '>', 0)->with('arrondissement')->orderBy('categorie', 'desc')->limit(5)->get()
        );    
    }

    public function list() // Liste toutes les communes
    {

        return response()->json(
            FtthCommune::all()
        );
    }
}

   