<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('sender_card',100)->index();
            $table->string('receiver_card',100)->index();
            $table->unsignedBigInteger('account_id')->index();
            $table->unsignedBigInteger('payment_id')->index();
            $table->bigInteger('amount');
            $table->integer('percentage');
            $table->integer('status');
            $table->integer('is_sent')->comment("0 -> merchant puli cardda 1 -> carddan r/s o'tqazgan");

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('payment_id')->references('id')->on('payments');

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
        Schema::dropIfExists('transactions');
    }
}
