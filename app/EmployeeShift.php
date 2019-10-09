<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
    //

    public function employee()
    {
        return $this->hasOne('App\Employee','emp_no','emp_no');
    }

    public function shift()
    {
        return $this->hasOne('App\Shift','shift_code','shift_code');
    }

    public function shifts()
    {
        return $this->hasMany('App\Shift','shift_code','shift_code');
    }
}
