<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PRUser extends Model
{
    public function uoms()
    {
        return $this->hasOne('App\UnitOfMeasure', 'uom_code', 'uom_code');
    }

    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
    }
    
    public function item_details()
    {
        return $this->hasOne('App\ItemMaster', 'item_code', 'item_code');
    }

}
