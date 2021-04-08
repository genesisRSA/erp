<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProceduresMasterCopy extends Model
{
    public function procedures()
    {
        return $this->hasOne('App\Procedure', 'document_no', 'document_no');
    }
}
