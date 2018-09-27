<?php
 
 
namespace App\Http\Controllers;
 
 
 
use Illuminate\Http\Request;
 
use App\Models\Region;
  
 
class SearchController extends Controller
 
{
 
   public function index() 
    {
    // return view('search.search');
    }    
    
    public function search(Request $request)    
    {    
        if($request->ajax())
        {
            $communes=Commune::where('nom_commune','LIKE','%'.$request->search."%")->get();        
            if($communes)        
            {        
                return Response($communes);
            }
            else 
            {
                echo('Aucune commune trouvée!');
            }
        }
    } 
}