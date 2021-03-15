<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesForecast extends Model
{   
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
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
    
    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'created_by');
    }
}
