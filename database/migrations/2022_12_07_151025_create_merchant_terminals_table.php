<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_terminals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id')->index();
            $table->string('merchant',100);
            $table->string('terminal',100);
            $table->bigInteger('balance');
            $table->boolean('status');
            $table->foreign('merchant_id')->references('id')->on('merchants');
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
        Schema::dropIfExists('merchant_terminals');
    }
}
