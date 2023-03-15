<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment("1 -> merchant 2 -> transit 3 -> ItUnisoft 4 -> Mko 5 -> Bank");
            $table->string('number');
            $table->string('inn',12);
            $table->string('name',200);
            $table->string('filial',10);
            $table->unsignedBigInteger('card_id')->nullable()->index();
            $table->float('percentage')->nullable();
            $table->foreign('card_id')->references('id')->on('cards');
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
        Schema::dropIfExists('accounts');
    }
}
