<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthDepartement;
use App\Models\FtthEpci;
use App\Models\FtthCommune;
use App\Models\Departement;


use Illuminate\Support\Facades\Storage;

class FtthDepartementController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  Request  $request 
     * @param  int  $id Identifiant de la ligne dans la table departemernts
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un département
    {

        return response()->json(
            FtthDepartement::findOrFail($id)
        );
    }      
    
    public function topshowepci(Request $request, $id) // Affiche le top ftth du dernier trimestre d'un departement
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;
        $departement = Departement::findOrFail($id);
        return response()->json(
            $ftthtopepcis = FtthEpci::where('departement_id', $departement->id)->where('trimestre', 1)->where('annee', 2018)->with('epci')->where('categorie', '>', 0)->orderBy('categorie', 'desc')->limit(5)->get()
        );    
    }
    public function topshowcommunes(Request $request, $id) // Affiche le top ftth du dernier trimestre d'un departement
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;
        $departement = Departement::findOrFail($id);
        return response()->json(
            $ftthtopcommunes = FtthCommune::where('departement_id', $departement->id)->where('trimestre', 1)->where('annee', 2018)->where('categorie', '>', 0)->with('commune')->orderBy('categorie', 'desc')->limit(5)->get()
        );    
    }

    public function list() // Liste tous les ftthdépartements
    {

        return response()->json(
            FtthDepartement::all()
        );
    }
}

   