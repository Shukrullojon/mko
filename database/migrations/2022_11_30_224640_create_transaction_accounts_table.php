<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('sender_id')->index();
            $table->unsignedBigInteger('receiver_id')->index();
            $table->bigInteger('amount');
            $table->integer('transactionId');
            $table->tinyInteger('status');

            $table->foreign('sender_id')->references('id')->on('accounts');
            $table->foreign('receiver_id')->references('id')->on('accounts');

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
        Schema::dropIfExists('transaction_accounts');
    }
}
