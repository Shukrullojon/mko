<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('number',16);
            $table->string('expire',4);
            $table->tinyInteger('type')->comment("0 -> client, 1 -> merchant, 2 -> pay later");
            $table->string('owner',100);
            $table->bigInteger('balance')->default(0);
            $table->bigInteger('hold_amount')->default(0);
            $table->string('phone',13)->nullable();
            $table->string('token',100);
            $table->tinyInteger('status')->comment("0 -> new create 1 -> active");
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
        Schema::dropIfExists('cards');
    }
}
