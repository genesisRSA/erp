<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    public function procedures_revisions()
    {
        return $this->hasOne('App\ProceduresRevision', 'document_no', 'document_no');
    }
    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'created_by');
    }
}
