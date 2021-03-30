<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesProductListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_product_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('quot_code');
            $table->string('prod_code');
            $table->string('prod_name');
            $table->string('uom_code');
            $table->string('currency_code');
            $table->double('unit_price');
            $table->integer('quantity');
            $table->string('total_price');
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
        Schema::dropIfExists('sales_product_lists');
    }
}
