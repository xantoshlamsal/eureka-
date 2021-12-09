<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Currency', function (Blueprint $table) {
            $table->id();
            $table->string('Code',10);
            $table->string('Name',50);
            $table->string('NameLoc',256);
            $table->string('Alias',10);
            $table->integer('RateQuoteMethod');
            $table->integer('DecimalLength');
            $table->boolean('IsNormalCurrency');
            $table->boolean('IsConvertibleCurrency');
            $table->integer('TranOption');
            $table->string('IsoCode', 10);
            $table->boolean('IsLowerDeno');
            $table->string('LowerDenoName',100);
            $table->integer('LowerDenoSize');
            $table->timestamp('TranDate');
            $table->integer('TranUserId');
            $table->tinyInteger('Status');
            $table->integer('StatusChangeUserId');
            $table->timestamp('StatusChangeDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currencies', function (Blueprint $table) {
            $table->dropIfExists();
        });
    }
}
