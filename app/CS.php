<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CS extends Model
{
    //
    public function filer_employee()
    {
        return $this->hasOne('App\Employee','emp_no','filer');
    }

    public function approved_employee()
    {
        return $this->hasOne('App\Employee','emp_no','last_approved_by');
    }

    public function approver_employee()
    {
        return $this->hasOne('App\Employee','emp_no','next_approver');
    }
}
