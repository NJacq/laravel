<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Departement;
use App\Models\Region;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*
        $departement = Departement::where('code_departement', 25)->first();
        echo $departement->nom_departement;
        echo $departement->region_id;
        echo $departement->region->nom_region;
        */
        // $region = Region::find(8);
        // echo $region->nom_region;
        // foreach($region->departements as $departement) {
        //     echo $departement->nom_departement;
        //     echo '<br>';
        // }
        // exit;
        return view('index');
    }
}
