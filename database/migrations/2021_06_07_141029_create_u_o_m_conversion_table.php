<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUOMConversionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('u_o_m_conversions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uom_cnv_type');
            $table->string('uom_cnv_name');
            $table->string('uom_from');
            $table->string('uom_from_value');
            $table->string('uom_to');
            $table->string('uom_to_value');
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
        Schema::dropIfExists('u_o_m_conversions');
    }
}
