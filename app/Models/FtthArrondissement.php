<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthArrondissement extends Model
{
    protected $table = 'fttharrondissements';
    protected $guarded = ['id'];
    protected $appends = ['pourcentage'];

    public function arrondissement()
    {
        return $this->belongsTo('App\Models\Arrondissement');
    }
    public function getPourcentageAttribute()
    {
        $valeurs = [
            0 => '',
            5 => '0% à 10%',
            10 => '10% à 25%',
            25 => '25% à 50%',
            50 => '50% à 80%',
            80 => '80% à 100%'
        ];
        if(!empty($valeurs[$this->categorie])) {
            return $valeurs[$this->categorie];
        } else {
            return 'N/A';
        }
    }
}

