<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    public function prod()
    {
        return $this->hasOne('App\Product','prod_code','prod_code');
    }
}
