<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOTDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_t_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('ref_no');
            $table->text('emp_no');
            $table->date('ot_date');
            $table->text('ot_start');
            $table->text('ot_end');
            $table->text('reason');
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
        Schema::dropIfExists('o_t_details');
    }
}
