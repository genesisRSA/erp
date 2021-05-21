<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryIssuanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_issuances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('issuance_code');
            $table->string('site_code');
            $table->string('requestor');
            $table->string('purpose');
            $table->string('project_code')->nullable();
            $table->string('assy_code')->nullable();
            $table->string('status');
            $table->integer('current_sequence');
            $table->string('current_approver');
            $table->json('matrix');
            $table->json('matrix_h')->nullable();
            $table->string('last_approved_by')->nullable();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('inventory_issuances');
    }
}
