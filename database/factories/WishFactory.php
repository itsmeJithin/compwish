<?php
/**
 * User: jithinvijayan
 * Date: 15/03/19
 * Time: 12:22 PM
 */

use App\Models\CategoryItem;
use App\Models\User;
use App\Models\Wish;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Wish::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(100),
        'category_item_id' => function () {
            return CategoryItem::inRandomOrder()->first()->category_item_id;
        },
        'user_id' => function () {
            return User::inRandomOrder()->first()->user_id;
        },
        'is_journey' => 0,
        'created_at' => now()
    ];
});
