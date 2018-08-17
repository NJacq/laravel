<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class departementsImport extends Controller
{
     /**
     * Create a new instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Validate the request...

        $dpts = new Departements;

        $dpts->name = $request->name;

        $dpts->save();

        // $dpts = App\Departements::find(1);

        // $dpts->name = 'New';

        // $dpts->save();
    }
}
