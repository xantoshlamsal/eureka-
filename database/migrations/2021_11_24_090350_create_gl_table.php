<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gl', function (Blueprint $table) {
            $table->id();
            $table->string('GlName');
//            $table->string('GlNameLocLang')->nullable(true);
//            $table->string('GlType',1);
            $table->integer('GlCode');
//            $table->boolean('IsAutoCreated');
//            $table->integer('MasterGLId')->constrained('gl');
            $table->tableMandatoryFields();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gl', function (Blueprint $table) {
            //
        });
    }
}
