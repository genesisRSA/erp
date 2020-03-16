<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObDetails extends Migration
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
            $table->dropColumn('purpose');
            $table->dropColumn('ob_desc');
            $table->dropColumn('destination');
            $table->dropColumn('ob_date');
            $table->dropColumn('ob_from');
            $table->json('ot_details')->after('date_filed');
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
