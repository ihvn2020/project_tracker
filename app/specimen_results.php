<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class specimen_results extends Model
{
    protected $guarded = [];

    public function sresults()
    {
        return $this->hasMany('App\sresults','result_id','id');
    }

    public function drug_resistance()
    {
        return $this->hasMany('App\drug_resistance','result_id','id');
    }
}
