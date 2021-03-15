<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemSubCategory extends Model
{
    public function item_cat()
    {
        return $this->hasOne('App\ItemCategory','cat_code','cat_code');
    }
}
