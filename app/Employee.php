<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Employee extends Model
{
    //
    protected $appends = ['full_name'];

    public function site()
    {
        return $this->hasOne('App\Site','site_code','site_code');
    }

    public function department()
    {
        return $this->hasOne('App\Department','dept_code','dept_code');
    }

    public function section()
    {
        return $this->hasOne('App\Section','sect_code','sect_code');
    }

    public function team()
    {
        return $this->hasMany('App\Employee','reports_to','emp_no');
    }

    public function getIdNoAttribute($value)
    {
        return Crypt::encrypt($this->id);
    }

    public function getFullNameAttribute(){
        $middle = $this->mname ? " ".ucfirst($this->mname)[0]+"." : '';
        return  ucfirst($this->emp_lname).", ".ucfirst($this->emp_fname).$middle;
    }
}
