<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSignages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('signages', function (Blueprint $table) {
            //
            $table->string('created_by')->after('is_enabled');
            $table->string('status')->after('created_by');
            $table->string('last_approved_by')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('signages', function (Blueprint $table) {
            //
        });
    }
}
