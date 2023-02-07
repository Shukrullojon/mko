<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('application_id',100);
            $table->string('client_code',100)->comment("give mko");
            $table->unsignedBigInteger('card_id')->index();
            $table->bigInteger('limit');
            $table->tinyInteger('limit_status');
            $table->bigInteger('used_limit');
            $table->date("date_expiry");
            $table->string('pnfl',14);
            $table->string('passport',9)->nullable();
            $table->string('first_name',40);
            $table->string('last_name',40);
            $table->string('middle_name',40);
            $table->tinyInteger('status');
            $table->tinyInteger('is_sent')->default(0);
            $table->foreign('card_id')->references('id')->on('cards');
            $table->tinyInteger('is_sent_code')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
