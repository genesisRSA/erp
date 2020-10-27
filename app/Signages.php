<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signages extends Model
{
    //
    public function requestor()
    {
        return $this->hasOne('App\Employee','emp_no','created_by');
    }
}
