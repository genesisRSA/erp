<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    public function drawings_revisions()
    {
        return $this->hasOne('App\DrawingsRevision', 'document_no', 'document_no');
    }
    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'created_by');
    }
}
