<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawingsRevision extends Model
{
    public function drawings()
    {
        return $this->hasOne('App\Drawings', 'ecn_code', 'ecn_code');
    }
}
