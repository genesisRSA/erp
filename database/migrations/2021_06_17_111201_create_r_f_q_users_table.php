<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRFQUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('r_f_q_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rfq_code');
            $table->string('assy_code')->nullable();
            $table->string('item_code');
            $table->string('uom_code');
            $table->double('required_qty');
            $table->string('required_delivery_date');
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
        Schema::dropIfExists('r_f_q_users');
    }
}
