<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $table = 'communes';
    protected $guarded = ['id'];

    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }
    public function ftthcommunes()
    {
        return $this->hasMany('App\Models\FtthCommune');
    }
    public function arrondissements()
    {
        return $this->hasMany('App\Models\Arrondissement');
    }
    public function statcommune()
    {
        return $this->hasMany('App\Models\StatCommune');
    }
    public function epci()
    {
        return $this->belongsTo('App\Models\Epci');
    }
}
