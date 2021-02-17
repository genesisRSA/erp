<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
    public function item_cat()
    {
        return $this->hasOne('App\Product','id','prod_code');
    }
}
