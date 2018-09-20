<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthEpci;
use App\Models\FtthCommune;
use App\Models\Epci;

use Illuminate\Support\Facades\Storage;

class FtthEpciController extends Controller
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
            FtthEpci::with('communes')->findOrFail($id)
        );
    }


    public function topshowcommunes(Request $request, $id) // Affiche le top ftth du dernier trimestre d'un departement
    {
        $trimestre = $request->trimestre;
        $annee = $request->annee;
        $epci = Epci::findOrFail($id);
        return response()->json(
            $ftthtopcommunes = FtthCommune::where('epci_id', $epci->id)->where('trimestre', 1)->where('annee', 2018)->where('categorie', '>', 0)->with('commune')->orderBy('categorie', 'desc')->limit(5)->get()
        );    
    }

    public function list() // Liste tous les epci
    {

        return response()->json(
            FtthEpci::with('communes')->all()
        );
    }
}

   