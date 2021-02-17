<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('ven_name');
            $table->text('ven_code');
            $table->text('ven_num_code');
            $table->text('ven_type');
            $table->integer('currency_id');
            $table->integer('term_id');
            $table->text('vat_type');
            $table->text('ven_website');
            $table->text('ven_address');
            $table->text('ven_email');
            $table->text('ven_no');
            $table->text('ven_person');
            $table->text('ven_person_pos');
            $table->text('remarks');
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
        Schema::dropIfExists('vendors');
    }
}
