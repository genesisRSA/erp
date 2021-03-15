<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabrication extends Model
{
    //
    public function assy()
    {
        return $this->hasOne('App\Assembly','assy_code','assy_code');
    }
}
