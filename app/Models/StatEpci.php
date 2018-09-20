<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatEpci extends Model
{
    protected $table = 'statepci';
    protected $guarded = ['id'];   

   
    public function epci()
    {
        return $this->belongsTo('App\Models\Epci');
    }
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }
 
}
