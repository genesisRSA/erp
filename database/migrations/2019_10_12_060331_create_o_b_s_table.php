<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_b_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('filer');
            $table->date('date_filed');
            $table->text('purpose');
            $table->text('destination');
            $table->date('ob_date');
            $table->text('ob_from');
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
        Schema::dropIfExists('o_b_s');
    }
}
