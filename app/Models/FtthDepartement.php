<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthDepartement extends Model
{
    protected $table = 'ftthdepartements';
    protected $guarded = ['id'];  
    protected $appends = ['pourcentage'];

    public function departement()
    {
        return $this->belongsTo('App\Models\Departement');
    }
    public function region()
    {
        return $this->belongsTo('App\Models\region');
    }
    public function getPourcentageAttribute()
    {
        $valeurs = [
            0 => 'aucune ligne',
            5 => '0% à 10%',
            10 => '10% à 25%',
            25 => '25% à 50%',
            50 => '50% à 80%',
            80 => '80% à 100%'
        ];
        if(!empty($valeurs[$this->categorie])) {
            return $valeurs[$this->categorie];
        } else {
            return 'N/A (catégorie : '.$this->categorie.')';
        }
    }
}

