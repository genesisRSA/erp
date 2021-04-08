<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProceduresControlledCopy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('procedures_controlled_copies', function (Blueprint $table) {
            $table->string('file_name')->after('document_title');
            $table->string('released_by')->after('process_owner');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procedures_controlled_copies', function (Blueprint $table) {
            //
        });
    }
}
