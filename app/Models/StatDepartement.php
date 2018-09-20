<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatDepartement extends Model
{
    protected $table = 'statdepartements';
    protected $guarded = ['id'];   

   
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }
 
}
