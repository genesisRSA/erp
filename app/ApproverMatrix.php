<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApproverMatrix extends Model
{
  public function employee_details()
  {
    return $this->hasOne('App\Employee', 'emp_no', 'requestor');
  }
}
