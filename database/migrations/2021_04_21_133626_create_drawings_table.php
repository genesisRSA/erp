<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ecn_code'); // dpr code
            $table->string('customer_code'); // customer
            $table->string('project_code'); // ??
            $table->string('part_name'); // document title
            $table->string('drawing_no'); // document no
            $table->string('revision_no'); 
            $table->string('revision_date');
            $table->string('process_specs');
            $table->string('change_description');
            $table->string('change_reason');
            $table->string('assy_code');
            $table->string('fab_code');
            $table->string('file_name');
            $table->string('created_by');
            $table->integer('current_sequence');
            $table->string('current_approver');
            $table->json('matrix');
            $table->json('matrix_h');
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
        Schema::dropIfExists('drawings');
    }
}
