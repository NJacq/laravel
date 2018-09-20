<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StatArrondissement;
use App\Models\Arrondissement;
use App\Models\Commune;

use Illuminate\Support\Facades\Storage;

class StatArrondissementController extends Controller
{     
      /**
     * 
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table statCommunes
     * @return Response
     */
    
    public function showarrondissement($id) // Affiche le detail d'un arrondissement d'une commune
    {
        $commune = Commune::findOrFail($id);
        return response()->json(
            $statarrondissements = StatArrondissement::with('arrondissement')->with('commune')->where('commune_id', $commune->id)->where('pourcentage_progression', '>', 0)->orderBy('pourcentage_progression', 'desc')->limit(5)->get()
        );
    }   
}

   