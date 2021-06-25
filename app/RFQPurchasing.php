<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RFQPurchasing extends Model
{
    public function uoms()
    {
        return $this->hasOne('App\UnitOfMeasure', 'uom_code', 'uom_code');
    }
    
    public function item_details()
    {
        return $this->hasOne('App\ItemMaster', 'item_code', 'item_code');
    }
    
    public function ven_details()
    {
        return $this->hasOne('App\Vendor', 'ven_code', 'ven_code');
    }

    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
    }
}
