<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatCommune extends Model
{
    protected $table = 'statcommunes';
    protected $guarded = ['id'];   

   
    public function epci()
    {
        return $this->belongsTo('App\Models\Epci');
    }
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }
    public function commune()
    {
        return $this->belongsTo('App\Models\Commune');
    }
 
}
