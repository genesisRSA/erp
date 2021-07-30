<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePRHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_r_headers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pr_code');
            $table->string('date_requested');
            $table->string('requestor');
            $table->string('purpose');
            $table->string('project_code')->nullable();
            $table->string('remarks');
            $table->string('status');
            $table->string('current_sequence');
            $table->string('current_approver');
            $table->json('matrix');
            $table->json('matrix_h')->nullable();
            $table->string('last_approved_by')->nullable();
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
        Schema::dropIfExists('p_r_headers');
    }
}
