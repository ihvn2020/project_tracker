<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class patients extends Model
{
    protected $guarded = [];


    public function samples()
    {
        return $this->hasMany('App\samples','patient_id','patient_id');
    }

}