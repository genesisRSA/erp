<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class InventoryRTV extends Model
{
    public function sites()
    {
        return $this->hasOne('App\Site', 'site_code', 'site_code');
    }

    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'requestor');
    }
}