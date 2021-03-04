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

    public function site()
    {
        return $this->hasOne('App\Site','site_code','site_code');
    }
}
