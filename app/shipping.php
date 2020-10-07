<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shipping extends Model
{
    protected $guarded = [];


    public function samples()
    {
        return $this->hasMany('App\samples','shipping_manifest_id','shipping_manifest_id');
    }

}
