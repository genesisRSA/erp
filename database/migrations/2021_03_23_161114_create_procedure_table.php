<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procedure', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dpr_code');
            $table->string('requested_date');
            $table->string('file_name');
            $table->string('document_title');
            $table->string('document_no');
            $table->string('revision_no');
            $table->string('change_description');
            $table->string('change_reason');
            $table->string('created_by');
            $table->string('reviewed_by')->nullable();
            $table->string('approved_by')->nullable();
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
        Schema::dropIfExists('procedure');
    }
}
