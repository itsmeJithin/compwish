<?php
/**
 * User: jithinvijayan
 * Date: 15/03/19
 * Time: 12:03 PM
 */

use App\Models\ServiceProvider;
use App\User;
use Illuminate\Support\Str;
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

$factory->define(ServiceProvider::class, function (Faker $faker) {
    return [
        'service_provider_id' => $faker->uuid,
        'name' => $faker->name,
        'address' => $faker->text(100),
        'email' => $faker->email,
        'owner_name' => $faker->firstName,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'mobile_number' => $faker->phoneNumber,
        'is_active' => 1,
        'opening_time' => $faker->time('H:i:s'),
        'closing_time' => $faker->time('H:i:s'),
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
    ];
});