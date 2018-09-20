<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';
    protected $guarded = ['id'];
    

    public function departements()
    {
        return $this->hasMany('App\Models\Departement');
    }
    public function ftthdepartements()
    {
        return $this->hasMany('App\Models\FtthDepartement');
    }
    public function ftthregions()
    {
        return $this->hasMany('App\Models\FtthRegion');
    }    
    public function statregions()
    {
        return $this->hasMany('App\Models\StatRegion');
    }    
    public function statdepartements()
    {
        return $this->hasMany('App\Models\StatDepartement');
    }    

}