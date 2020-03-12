<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->uuid('service_provider_id');
            $table->primary('service_provider_id');
            $table->string('name', 127);
            $table->string('address', 255);
            $table->string('email', 120)->unique();
            $table->string('owner_name', 50)->nullable();
            $table->string('owner_contact_number', 20)->nullable();
            $table->string('password');
            $table->decimal('latitude', 9, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('mobile_number', 20);
            $table->string('land_phone_number', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
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
        Schema::dropIfExists('service_providers');
    }
}
