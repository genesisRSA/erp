<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReturn extends Model
{
    public function sites()
    {
        return $this->hasOne('App\Site', 'site_code', 'site_code');
    }
}
