<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departements';
    protected $guarded = ['id'];

    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }
    public function ftthdepartements()
    {
        return $this->hasMany('App\Models\FtthDepartement');
    }
    public function communes()
    {
        return $this->hasMany('App\Models\Commune');
    }
    public function epci()
    {
        return $this->hasMany('App\Models\Epci');
    }
    public function statdepartements()
    {
        return $this->hasMany('App\Models\StatDepartement');
    }
    public function statepci()
    {
        return $this->hasMany('App\Models\StatEpci');
    }
    public function ftthepci()
    {
        return $this->hasMany('App\Models\FtthEpci');
    }
    public function statcommunes()
    {
        return $this->hasMany('App\Models\StatCommune');
    }
    public function urlcartedepartements()
    {
        return $this->hasMany('App\Models\UrlCarteDepartement');
    }
}
