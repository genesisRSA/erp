<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function customers()
    {
        return $this->hasOne('App\Customer', 'cust_code', 'cust_code');
    }
    
    public function products()
    {
        return $this->hasOne('App\Product', 'prod_code', 'prod_code');
    }

    public function sites()
    {
        return $this->hasone('App\Site', 'site_code', 'site_code');
    }

    public function uoms()
    {
        return $this->hasone('App\UnitOfMeasure', 'uom_code', 'uom_code');
    }
}
