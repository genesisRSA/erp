<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->boolean('is_admin')->after('password');
            $table->boolean('is_hr')->after('is_admin');
            $table->boolean('is_lv_approver')->after('is_hr');
            $table->boolean('is_ot_approver')->after('is_lv_approver');
            $table->boolean('is_cs_approver')->after('is_ot_approver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
