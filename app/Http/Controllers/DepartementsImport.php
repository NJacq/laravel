<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartementsImport extends Controller
{
     /**
     * Create a new instance.
     *
     * @param  Request  $request
     * @return Response
     */
    public function departementsImport(Request $request)
    {
        // Validate the request...

        $dpts = new Departements;

        $dpts->name = $request->name;

        $dpts->save();

    }
}
