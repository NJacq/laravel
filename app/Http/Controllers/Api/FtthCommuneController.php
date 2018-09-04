<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\FtthCommune;

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

    public function list() // Liste toutes les communes
    {

        return response()->json(
            FtthCommune::all()
        );
    }
}

   