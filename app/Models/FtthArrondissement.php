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

}

