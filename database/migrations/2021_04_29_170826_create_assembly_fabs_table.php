<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssemblyFabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assembly_fabs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_code');
            $table->string('assy_code');
            $table->string('fab_code');
            $table->string('fab_desc');
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('thickness')->nullable();
            $table->string('radius')->nullable();
            $table->string('created_by');
            $table->string('dwg_status')->nullable();
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
        Schema::dropIfExists('assembly_fabs');
    }
}
