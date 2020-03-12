<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->unique();
            $table->primary('user_id');
            $table->string('first_name', 20);
            $table->string('last_name', 20)->nullable();
            $table->string('email')->unique();
            $table->string('mobile_number', 20)->unique();
            $table->string('country', 20)->nullable();
            $table->string('password');
            $table->string('avatar')->default('avatar.png');
            $table->unsignedInteger('role_id');
            $table->boolean('is_active')->default(0);
            $table->foreign('role_id')->references('role_id')->on('roles');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('activation_token');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
