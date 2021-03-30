<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_quotations');
    }
    
    public function up()
    {
        Schema::create('sales_quotations', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('site_code');
            $table->string('quot_code');
            $table->string('cust_code');
            $table->string('forecast_code')->nullable();
            $table->string('payment_term_id');
            $table->string('status');
            $table->string('created_by');
            $table->integer('current_sequence');
            $table->string('current_approver');
            $table->json('matrix');
            $table->json('matrix_h')->nullable();
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
  
}
