<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('cust_name');
            $table->text('cust_code');
            $table->text('cust_num_code');
            $table->text('cust_type');
            $table->integer('currency_id');
            $table->integer('term_id');
            $table->text('vat_type');
            $table->text('cust_website');
            $table->text('cust_address');
            $table->text('cust_email');
            $table->text('cust_no');
            $table->text('cust_person');
            $table->text('cust_person_pos');
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
        Schema::dropIfExists('customers');
    }
}
