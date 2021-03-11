<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesVisit extends Model
{
    public function sites()
    {
        return $this->hasone('App\Site', 'site_code', 'site_code');
    }
}
