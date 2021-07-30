<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePRUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_r_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pr_code');
            $table->string('rfq_code');
            $table->string('assy_code')->nullable();
            $table->string('item_code');
            $table->string('uom_code');
            $table->double('required_qty');
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
        Schema::dropIfExists('p_r_users');
    }
}
