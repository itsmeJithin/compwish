<?php

use App\Models\Category;
use App\Models\CategoryItem;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * User: jithinvijayan
 * Date: 13/03/19
 * Time: 10:40 PM
 */

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText(100),
        'is_active' => $faker->boolean(1),
        'created_at' => now(),
        'updated_at' => now()
    ];
});

$factory->define(CategoryItem::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText(100),
        'category_id' => function () {
            return Category::inRandomOrder()->first()->category_id;
        },
        'is_active' => $faker->boolean(1),
        'created_at' => now(),
        'updated_at' => now()
    ];
});


