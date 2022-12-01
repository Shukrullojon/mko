<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->index();
            $table->unsignedBigInteger('merchant_id')->index();
            $table->integer('period');
            $table->integer('persentage');
            $table->string('sender_card',100)->index();
            $table->bigInteger('amount');
            $table->date('date');
            $table->tinyInteger('is_transaction')->commnent("0->paymentni transaksiyalari qo'shilmagan 1 -> tranzaksiyalar qo'shilgan");
            $table->tinyInteger('status')->comment("0 -> payment check create 1 -> clientni cardidan hold_amount ga olinadi");

            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('payments');
    }
}
