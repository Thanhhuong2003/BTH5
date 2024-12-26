<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class usersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $faker = Faker::create();
            for ($i = 0; $i < 50; $i++) {
                DB::table('users')->insert([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'email_verified_at' => now(),
                    'password' => bcrypt('password'),
                    'bio' => $faker->sentence(10),
                    'avatar' => $faker->image,
                    'remember_token' => $faker-> md5
                ]);
            }
        }
    }
}
