<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatRegion extends Model
{
    protected $table = 'statregions';
    protected $guarded = ['id'];   

   
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }
    public function statdepartements()
    {
        return $this->hasMany('App\Models\StatDepartement');
    }

}
