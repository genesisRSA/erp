<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryRTVSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_r_t_v_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rtv_code');
            $table->string('site_code');
            $table->string('requestor');
            $table->string('reason');
            $table->string('status');
            $table->string('current_sequence');
            $table->string('current_approver');
            $table->json('matrix');
            $table->json('matrix_h')->nullable();
            $table->string('last_approved_by')->nullable();
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
        Schema::dropIfExists('inventory_r_t_v_s');
    }
}
