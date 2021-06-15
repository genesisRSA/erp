<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
    }

    public function sites()
    {
        return $this->hasOne('App\Site', 'site_code', 'site_code');
    }

    public function item_details()
    {
        return $this->hasOne('App\ItemMaster', 'item_code', 'item_code');
    }

    public function loctype()
    {
        return $this->hasOne('App\InventoryLocation', 'location_code', 'inventory_location_code');
    }

    public function uoms()
    {
        return $this->hasOne('App\UnitOfMeasure', 'uom_code', 'uom_code');
    }
}
