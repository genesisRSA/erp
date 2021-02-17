<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssembliesTable extends Migration
{
    /**
     * Run the migrations.
     * id,prod_code,assy_code,assy_desc,parent_assy_code
     * @return void
     */
    public function up()
    {
        Schema::create('assemblies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('prod_code');
            $table->string('assy_code');
            $table->string('assy_desc');
            $table->string('parent_assy_code');
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
        Schema::dropIfExists('assemblies');
    }
}
