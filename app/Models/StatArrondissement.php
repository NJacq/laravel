<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatArrondissement extends Model
{
    protected $table = 'statarrondissements';
    protected $guarded = ['id'];   

   
    public function arrondissement()
    {
        return $this->belongsTo('App\Models\Arrondissement');
    }
        public function commune()
    {
        return $this->belongsTo('App\Models\Commune');
    }
 
}
