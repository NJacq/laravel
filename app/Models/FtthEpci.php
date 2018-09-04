<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthEpci extends Model
{
    protected $table = 'ftthepci';
    protected $guarded = ['id'];

    public function epci()
{
    return $this->belongsTo('App\Models\Epci');
}
}

