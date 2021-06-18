<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RFQHeader extends Model
{
    public function sites()
    {
        return $this->hasOne('App\Site', 'site_code', 'site_code');
    }

    public function projects()
    {
        return $this->hasOne('App\Project', 'project_code', 'project_code');
    }
    
    public function assy()
    {
        return $this->hasOne('App\Assembly', 'assy_code', 'assy_code');
    }

    public function employee_details()
    {
        return $this->hasOne('App\Employee', 'emp_no', 'requestor');
    }

    public function item_details()
    {
        return $this->hasOne('App\ItemMaster', 'item_code', 'item_code');
    }
}
