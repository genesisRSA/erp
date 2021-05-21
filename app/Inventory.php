<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
    }
}
