<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemMaster extends Model
{
    //
    public function item_cat()
    {
        return $this->hasOne('App\ItemCategory','cat_code','cat_code');
    }

    public function item_subcat()
    {
        return $this->hasOne('App\ItemSubCategory','subcat_code','subcat_code');
    }

    public function uom_details()
    {
        return $this->hasOne('App\UnitOfMeasure', 'uom_code', 'uom_code');
    }
}
