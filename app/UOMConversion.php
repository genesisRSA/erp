<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UOMConversion extends Model
{
    public function uom_details()
    {
        return $this->hasOne('App\UnitOfMeasure', 'uom_code', 'uom_to');
    }

    // public function uom_from_details()
    // {
    //     return $this->hasOne('App\ItemMaster', 'item_code', 'item_code');
    // }
}
