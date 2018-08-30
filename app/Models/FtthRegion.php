<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtthRegion extends Model
{
    protected $table = 'ftthregions';
    protected $guarded = ['id'];
   
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

}
