<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Epci extends Model
{
    protected $table = 'epci';
    protected $guarded = ['id'];

    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }
    public function communes()
    {
        return $this->hasMany('App\Models\Commune');
    }
    public function ftthepci()
    {
        return $this->hasMany('App\Models\FtthEpci');
    }
    public function ftthcommune()
    {
        return $this->hasMany('App\Models\FtthCommune');
    }
    public function statepci()
    {
        return $this->hasMany('App\Models\StatEpci');
    }
    public function statcommune()
    {
        return $this->hasMany('App\Models\StatCommune');
    }
    
}
