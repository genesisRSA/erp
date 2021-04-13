<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProceduresMasterCopy extends Model
{   
    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'process_owner');
    }
    public function dept_details()
    {
        return $this->hasOne('App\Department', 'dept_code', 'department');
    }
}
