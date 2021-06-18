<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RFQUser extends Model
{
    public function uoms()
    {
        return $this->hasOne('App\UnitOfMeasure', 'uom_code', 'uom_code');
    }
    
    public function item_details()
    {
        return $this->hasOne('App\ItemMaster', 'item_code', 'item_code');
    }
}
