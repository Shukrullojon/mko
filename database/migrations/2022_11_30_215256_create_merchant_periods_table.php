<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchant_periods', function (Blueprint $table) {
            $table->id();
            $table->integer("merchant_id");
            $table->integer("period");
            $table->integer("percentage");
            $table->tinyInteger("status")->comment("0 -> no active 1 -> active");
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
        Schema::dropIfExists('merchant_periods');
    }
}
