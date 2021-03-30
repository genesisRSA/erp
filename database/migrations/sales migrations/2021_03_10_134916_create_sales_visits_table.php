<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_code');
            $table->string('visit_code');
            $table->string('loc_name');
            $table->double('loc_longhitude');
            $table->double('loc_latitude');
            $table->string('date_visit');
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
        Schema::dropIfExists('sales_visits');
    }
}
