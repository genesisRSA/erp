<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    public function prod_cat()
    {
        return $this->hasOne('App\ProductCategory','id','prodcat_id');
    }
}
