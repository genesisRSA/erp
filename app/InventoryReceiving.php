<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventoryReceiving extends Model
{
    public function currency()
    {
        return $this->hasOne('App\Currency', 'currency_code', 'currency_code');
    }

    public function logs()
    {
        return $this->hasOne('App\InventoryLog', 'trans_code', 'receiving_code');
    }
}
