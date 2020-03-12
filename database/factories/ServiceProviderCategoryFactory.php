<?php

use App\Models\Category;
use App\Models\ServiceProvider;
use App\Models\ServiceProviderCategory;
use App\User;
use Faker\Generator as Faker;


$factory->define(ServiceProviderCategory::class, function (Faker $faker) {
    return [
        'service_provider_id' => function () {
            return ServiceProvider::inRandomOrder()->first()->service_provider_id;
        },
        'category_id' => function () {
            return Category::inRandomOrder()->first()->category_id;
        },
        'created_at' => now(),
        'updated_at' => now()
    ];
});
