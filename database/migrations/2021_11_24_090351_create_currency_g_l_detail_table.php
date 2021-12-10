<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyGLDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_gl_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CurrencyGLMasterId')->constrained('currency_gl_master');
            $table->foreignId('GlId')->constrained('gl');
            $table->foreignId('TranTypeId')->constrained('currency_tran_type');
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
        Schema::table('currency_gl_detail', function (Blueprint $table) {
            //
        });
    }
}
