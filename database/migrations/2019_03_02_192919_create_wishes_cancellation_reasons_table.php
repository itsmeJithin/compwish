<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishesCancellationReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishes_cancellation_reasons', function (Blueprint $table) {
            $table->bigIncrements('wish_cancellation_reason_id');
            $table->unsignedBigInteger('reason_id');
            $table->unsignedBigInteger('wish_id');
            $table->string('description', 255)->nullable();
            $table->string('other_reason', 150)->nullable();
            $table->uuid('user_id');
            $table->timestamps();
            $table->foreign('wish_id')->references('wish_id')->on('wishes');
            $table->foreign('reason_id')->references('cancellation_reason_id')->on('cancellation_reasons');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wishes_cancellation_reasons');
    }
}
