<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlCarteDepartement extends Model
{
    protected $table = 'urlcartedepartements';
    protected $guarded = ['id'];   

   
    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }

 
}
