<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_t_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('ref_no');
            $table->text('filer');
            $table->date('date_filed');
            $table->json('ot_details');
            $table->text('status');
            $table->string('last_approved_by');
            $table->date('last_approved');
            $table->string('next_approver');
            $table->json('logs');
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
        Schema::dropIfExists('o_t_s');
    }
}
