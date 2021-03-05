<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesForecast extends Model
{   
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
    }
    public function product()
    {
        return $this->hasOne('App\Product', 'prod_code', 'prod_code');
    }
}
