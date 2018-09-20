<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arrondissement extends Model
{
    protected $table = 'arrondissements';
    protected $guarded = ['id'];

    public function commune()
    {
        return $this->belongsTo('App\Models\Commune');
    }
    public function fttharrondissements()
    {
        return $this->hasMany('App\Models\FtthArrondissement');
    }
    public function statarrondissements()
    {
        return $this->hasMany('App\Models\StatArrondissement');
    }
}
