<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Models\Departement;



class DepartementController extends Controller
{     
      /**
     * Show the profile for the given departement.
     *
     * @param  int  $id Identifiant de la ligne dans la table departemernts
     * @return Response
     */
    
    public function show($id) // Affiche le detail d'un département
    {
        return view('departement.show', [
            'departement' => Departement::findOrFail($id),
            'title' => 'Détail du département :'
        ]); 
    }

    public function list() // Liste tous les départements
    {
        return view('departement.list',[
            'departements' => Departement::all()         
        ]);   
    }
}
