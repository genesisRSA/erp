<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDrawingControlledCopy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drawings_controlled_copies', function (Blueprint $table) {
            $table->string('receive_date')->after('status')->nullable();
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
        Schema::table('drawings_controlled_copies', function (Blueprint $table) {
            //
        });
    }
}
