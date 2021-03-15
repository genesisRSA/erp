<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('site_code');
            $table->text('forecast_code')->nullable(true);
            $table->text('order_code');
            $table->text('payment_term_id');
            $table->text('currency_code');
            $table->text('customer_po_specs');
            $table->text('customer_po_no');
            $table->text('status');
            $table->text('created_by');
            $table->text('current_sequence');
            $table->text('current_approver');
            $table->json('matrix');
            $table->json('matrix_h');
            $table->json('products');
            $table->text('updated_by');
            $table->text('approved_by');
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
        Schema::dropIfExists('sales_orders');
    }
}
