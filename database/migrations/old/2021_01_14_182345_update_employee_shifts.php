<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_shifts', function (Blueprint $table) {
            //
           $table->date('shift_date')->after('shift_code');
           $table->time('time_in')->after('shift_date');
           $table->time('time_out')->after('time_in');
           $table->text('shift_day')->after('time_out');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_shifts', function (Blueprint $table) {
            //
           $table->dropColumn('date_from');
           $table->dropColumn('date_to');
           $table->dropColumn('remarks');
        });
    }
}
