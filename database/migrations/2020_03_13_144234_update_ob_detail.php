<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateObDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('o_b_s', function (Blueprint $table) {
            //
            $table->dropColumn('ot_details');
            $table->json('ob_details')->after('date_filed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('o_b_s', function (Blueprint $table) {
            //
        });
    }
}
