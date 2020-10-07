<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class drug_resistance extends Model
{
    protected $guarded = [];

    public function specimen_results()
    {
        return $this->belongsTo('App\specimen_results','id','result_id');
    }
}
