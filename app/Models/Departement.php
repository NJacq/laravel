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
}
