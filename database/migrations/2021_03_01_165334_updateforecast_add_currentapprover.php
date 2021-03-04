<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateforecastAddCurrentapprover extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_forecasts', function (Blueprint $table) {
            $table->integer('current_sequence')->after('created_by');
            $table->string('current_approver')->after('created_by');
            $table->json('matrix_h')->after('matrix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_forecasts', function (Blueprint $table) {
            //
        });
    }
}
