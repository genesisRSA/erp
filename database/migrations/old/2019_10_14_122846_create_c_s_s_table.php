<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCSSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_s_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('filer');
            $table->text('type');
            $table->date('date_filed');
            $table->date('date_from');
            $table->text('orig_sched');
            $table->date('date_to');
            $table->text('new_sched');
            $table->text('reason');
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
        Schema::dropIfExists('c_s_s');
    }
}
