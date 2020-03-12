<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWishSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wish_settings', function (Blueprint $table) {
            $table->bigIncrements('wish_setting_id');
            $table->unsignedBigInteger('wish_id');
            $table->boolean("is_notification_enabled")->default(true);
            $table->dateTime('send_notification_from')->nullable();
            $table->dateTime('send_notification_to')->nullable();
            $table->boolean("is_reminder_enabled")->default(true);
            $table->double('remind_in_radius')->nullable();
            $table->foreign('wish_id')->references('wish_id')->on('wishes');
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
        Schema::dropIfExists('wish_settings');
    }
}
