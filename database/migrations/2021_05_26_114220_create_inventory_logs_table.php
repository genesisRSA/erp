<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trans_code');
            $table->string('trans_type');
            $table->string('status');
            $table->string('trans_date');
            $table->string('item_code');
            $table->string('sku')->nullable();
            $table->string('inventory_location_code');
            $table->string('currency_code');
            $table->integer('quantity');
            $table->double('unit_price');
            $table->double('total_price');
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
        Schema::dropIfExists('inventory_logs');
    }
}
