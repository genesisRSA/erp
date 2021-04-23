<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawingsRevisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drawings_revisions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ecn_code');
            $table->string('cust_code');
            $table->string('project_code');
            $table->string('part_name');
            $table->string('drawing_no');
            $table->string('revision_no');
            $table->string('revision_date');
            $table->string('process_specs');
            $table->string('change_description');
            $table->string('change_reason');
            $table->string('assy_code');
            $table->string('fab_code');
            $table->string('file_name');
            $table->string('created_by');
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
        Schema::dropIfExists('drawings_revisions');
    }
}
