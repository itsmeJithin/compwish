<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProviderCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider_categories', function (Blueprint $table) {
            $table->bigIncrements('service_provider_category_id');
            $table->uuid('service_provider_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('service_provider_id')->references('service_provider_id')->on('service_providers');
            $table->foreign('category_id')->references('category_id')->on('categories');
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
        Schema::dropIfExists('service_provider_categories');
    }
}
