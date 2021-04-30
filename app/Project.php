<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function customers()
    {
        return $this->hasOne('App\Customer', 'cust_code', 'cust_code');
    }
}
