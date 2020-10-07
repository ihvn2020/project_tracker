<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class samples extends Model
{
    protected $guarded = [];

    public function patients()
    {
        return $this->belongsTo('App\patients','patient_id','patient_id');
    }
}
