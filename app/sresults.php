<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sresults extends Model
{
    protected $guarded = [];
    
    public function specimen_results()
    {
        return $this->belongsTo('App\specimen_results','id','result_id');
    }
}
