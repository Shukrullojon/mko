<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string("date",20)->nullable();
            $table->string("dtAcc",30)->nullable();
            $table->string("dtAccName",150)->nullable();
            $table->string("dtMfo",10)->nullable();
            $table->string("purpose",255)->nullable();
            $table->string("debit",250)->nullable();
            $table->string("credit",250)->nullable();
            $table->string("numberTrans",250)->nullable();
            $table->tinyInteger("type")->nullable();
            $table->string("ctAcc",30)->nullable();
            $table->string("ctAccName",255)->nullable();
            $table->string("ctMfo",10)->nullable();
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
        Schema::dropIfExists('histories');
    }
}
