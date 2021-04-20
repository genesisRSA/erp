<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateControlledCopy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procedures_controlled_copies', function (Blueprint $table) {
            $table->string('orient_date')->after('status')->nullable();
            $table->string('orient_by')->after('orient_date')->nullable();
            $table->string('receive_date')->after('orient_by')->nullable();
            $table->string('receive_by')->after('receive_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procedures_controlled_copies', function (Blueprint $table) {
            //
        });
    }
}
