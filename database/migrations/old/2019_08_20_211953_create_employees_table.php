<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_no')->unique();   
            $table->mediumText('access_id'); 
            $table->mediumText('work_email');
            $table->mediumText('site_code');
            $table->mediumText('dept_code');  
            $table->mediumText('sect_code');   
            $table->mediumText('position');
            $table->mediumText('reports_to');
            $table->date('date_hired');
            $table->mediumText('emp_cat');
            $table->date('date_regularized');
            $table->boolean('is_hmo');
            $table->mediumText('hmo_cardno');
            $table->mediumText('sss_no');
            $table->mediumText('phil_no');
            $table->mediumText('pagibig_no');
            $table->mediumText('tin_no');
            $table->mediumText('emp_fname'); 
            $table->mediumText('emp_lname');
            $table->mediumText('emp_mname'); 
            $table->mediumText('emp_suffix');    
            $table->date('dob');
            $table->mediumText('gender');
            $table->mediumText('status');
            $table->json('dependencies');
            $table->mediumText('current_address');
            $table->mediumText('home_address');
            $table->mediumText('tel_no');
            $table->mediumText('mobile_no');
            $table->mediumText('personal_email');
            $table->mediumText('emergency_person');
            $table->mediumText('emergency_address');
            $table->mediumText('emergency_contact');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
