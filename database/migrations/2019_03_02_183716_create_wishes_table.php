<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishes', function (Blueprint $table) {
            $table->bigIncrements('wish_id');
            $table->string('name', 150);
            $table->unsignedBigInteger('category_item_id');
            $table->string('description', 255)->nullable();
            $table->uuid('user_id');
            $table->decimal('latitude', 9, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_journey')->default(0);
            $table->boolean('is_completed')->default(0);
            $table->boolean('is_cancelled')->default(0);
            $table->dateTime('journey_date')->nullable();
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('category_item_id')->references('category_item_id')->on('category_items');
            $table->unique(array('category_item_id', 'user_id'), 'unique_idx_wishes');
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
        Schema::dropIfExists('wishes');
    }
}
