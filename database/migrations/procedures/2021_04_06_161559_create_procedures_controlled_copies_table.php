<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProceduresControlledCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedures_controlled_copies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document_title');
            $table->string('revision_no');
            $table->string('document_no');
            $table->string('department');
            $table->string('process_owner');
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
        Schema::dropIfExists('procedures_controlled_copies');
    }
}
