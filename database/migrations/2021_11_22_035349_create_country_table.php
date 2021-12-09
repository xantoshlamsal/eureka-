<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Country', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('TwoCharCode', 2);
            $table->string('ThreeCharCode', 3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Country', function (Blueprint $table) {
            //
        });
    }
}
