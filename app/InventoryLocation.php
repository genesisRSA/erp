<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryLocation extends Model
{
    public function reqcat()
    {
        return $this->hasOne('App\ItemCategory', 'cat_code', 'required_item_category');
    }

    public function loctype()
    {
        return $this->hasOne('App\InventoryLocationType', 'location_code', 'location_type');
    }
}
