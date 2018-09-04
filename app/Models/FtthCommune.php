<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthCommune extends Model
{
    protected $table = 'ftthcommunes';
    protected $guarded = ['id'];
   
    public function commune()
    {
        return $this->belongsTo('App\Models\Commune');
    }

}
