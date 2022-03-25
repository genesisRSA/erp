<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSalesForecast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_forecasts', function(Blueprint $table){
            $table->string('cust_code')->after('site_code');
            $table->string('profit_center')->after('forecast_code');
            $table->string('target_month')->after('profit_center');
            $table->string('target_work_week')->after('target_month');
            $table->string('confidence_lvl')->after('target_work_week');
            $table->string('remarks')->after('confidence_lvl');
            $table->string('help_needed')->after('remarks');
            $table->string('dependencies')->after('help_needed');
            $table->string('assigned_sales')->after('dependencies'); // created by user
            $table->json('product_details')->after('assigned_sales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
