<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryReceivingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_receivings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_code');
            $table->string('receiving_code');
            $table->string('delivery_no');
            $table->string('delivery_date');
            $table->string('po_no');
            $table->string('status');
            $table->string('created_by');
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
        Schema::dropIfExists('inventory_receivings');
    }
}
