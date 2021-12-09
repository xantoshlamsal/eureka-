<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTranType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_tran_type', function (Blueprint $table) {
            $table->id();
            $table->integer('DispOrder');
            $table->smallInteger('TranTypeCode');
            $table->string('TranTypeName');
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
        Schema::table('currency_tran_type', function (Blueprint $table) {
            //
        });
    }
}
