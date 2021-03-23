<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemMastersTable extends Migration
{
    /**
     * Run the migrations.
     *(id,cat_code,subcat_code,item_code,item_desc,oem_partno (Optional) ,uom_code,safety_stock,maximum_stock, length (Optional) , width, (Optional)  thickness (Optional) , radius (Optional)) 
     * @return void
     */
    public function up()
    {
        Schema::create('item_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cat_code');
            $table->string('subcat_code');
            $table->string('item_code');
            $table->text('item_desc');
            $table->string('oem_partno');
            $table->string('uom_code');
            $table->string('safety_stock');
            $table->string('maximum_stock');
            $table->string('length');
            $table->string('width');
            $table->string('thickness');
            $table->string('radius');

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
        Schema::dropIfExists('item_masters');
    }
}
