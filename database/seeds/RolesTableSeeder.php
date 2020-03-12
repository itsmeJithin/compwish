<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => "USER",
            'description' => 'Basic User',
        ]);
        DB::table('roles')->insert([
            'name' => "ADMIN",
            'description' => 'Admin User',
        ]);
        DB::table('roles')->insert([
            'name' => "SUPER_ADMIN",
            'description' => 'Super Admin User',
        ]);
    }
}
