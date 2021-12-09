<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyGLMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_gl_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('CurrencyId')->constrained('currency');
            $table->timestamp('EffectDate');
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
        Schema::table('CurrencyGLMaster', function (Blueprint $table) {
            //
        });
    }
}
