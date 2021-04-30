<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrawingsRevision extends Model
{
    public function drawings()
    {
        return $this->hasOne('App\Drawing', 'ecn_code', 'ecn_code');
    }
}
