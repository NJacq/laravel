<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthDepartement extends Model
{
    protected $table = 'ftthdepartements';
    protected $guarded = ['id'];

    public function departement()
{
    return $this->belongsTo('App\Models\Departement');
}
}

