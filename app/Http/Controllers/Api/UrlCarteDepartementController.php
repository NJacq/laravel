<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;

use App\Models\UrlCarteDepartement;
use App\Models\Departement;

class UrlCarteDepartementController extends Controller
{     
      /**
     * 
     *
     * * @param  Request  $request 
     *     * @param  int  $id Identifiant de la ligne dans la table urlcartedepartement
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un departement
    {
        $departement = Departement::findOrFail($id);
        return response()->json(
            UrlCarteDepartement::with('departement')->where('departement_id', $departement->id)->get()
        );
    }
    public function list(Request $request) //  
    {
        return response()->json(
           UrlCarteDepartement::all()
        );
    }
}

   