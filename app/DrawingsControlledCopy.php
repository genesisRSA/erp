<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawingsControlledCopy extends Model
{
    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'designer');
    }
    public function dept_details()
    {
        return $this->hasOne('App\Department', 'dept_code', 'department');
    }
}
