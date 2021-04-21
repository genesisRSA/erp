<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawingsControlledCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawings_controlled_copies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ecn_code');
            $table->string('part_name');
            $table->string('customer_code');
            $table->string('project_code');
            $table->string('file_name');
            $table->string('revision_no');
            $table->string('drawing_no');
            $table->string('copy_no');
            $table->string('department');
            $table->string('process_owner');
            $table->string('released_by');
            $table->string('status');
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
        Schema::dropIfExists('drawings_controlled_copies');
    }
}
