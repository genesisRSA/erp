<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssemblyAdtlItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_adtl_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_code');
            $table->string('assy_code');
            $table->string('item_code');
            $table->string('item_desc');
            $table->string('uom_code');
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('thickness')->nullable();
            $table->string('radius')->nullable();
            $table->string('location');
            $table->string('created_by');
            $table->string('bom_status')->nullable();
            $table->string('pr_status')->nullable();
            $table->string('po_status')->nullable();
            $table->string('rcv_status')->nullable();
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
        Schema::dropIfExists('assembly_adtl_items');
    }
}
