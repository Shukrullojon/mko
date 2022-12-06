<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id')->index();
            $table->string("key")->index();
            $table->string("name",200);
            $table->string("filial",200);
            $table->string("address",200);
            $table->string("uzcard_merchant_id",200);
            $table->string("uzcard_terminal_id",200);
            $table->string("humo_merchant_id",200);
            $table->string("humo_terminal_id",200);
            $table->boolean("is_register_humo");
            $table->boolean("is_register_uzcard");
            $table->unsignedBigInteger("account_id")->index();
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('brand_id')->references('id')->on('brands');
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
        Schema::dropIfExists('merchants');
    }
}
