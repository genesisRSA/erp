<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesForecastsTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * id,
     * site_code,
     * forecast_code,
     * prod_code,
     * forecast_year,
     * forecast_month,
     * unit_price,
     * currency_code,
     * quantity,
     * total_price,
     * status,
     * created_by,
     * updated_by,
     * approved_by
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_forecasts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_code');
            $table->string('forecast_code');
            $table->string('prod_code');
            $table->string('forecast_year');
            $table->string('forecast_month');
            $table->double('unit_price');
            $table->string('currency_code');
            $table->integer('quantity');
            $table->string('uom_code');
            $table->string('total_price');
            $table->string('status');
            $table->string('created_by');
            $table->string('updated_by');
            $table->string('approved_by');
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
        Schema::dropIfExists('sales_forecasts');
    }
}
