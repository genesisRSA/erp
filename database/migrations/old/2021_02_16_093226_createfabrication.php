<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Createfabrication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabrications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('assy_code');
            $table->string('fab_code');  
            $table->string('fab_desc');   
            $table->string('length_');
            $table->string('width_');
            $table->string('thickness_');     
            $table->string('radius_');
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
        //
    }
}
