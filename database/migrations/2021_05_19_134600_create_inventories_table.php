<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('receiving_code');
            $table->string('sku');
            $table->string('item_code');
            $table->string('inventory_location_code');
            $table->string('currency_code');
            $table->integer('quantity');
            $table->double('unit_price');
            $table->double('total_price');
            $table->string('date_received');
            $table->string('date_issued')->nullable();
            $table->string('date_rtv')->nullable();
            $table->string('date_returned')->nullable();
            $table->string('status');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('inventories');
    }
}
