<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('users')->insert(
            array
            (
                [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt('Elipse#1126'),
                    'type' => 'system',
                ],
                [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt('Elipse#1126'),
                    'type' => 'system',
                ],
                [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt('Elipse#1126'),
                    'type' => 'system',
                ],
                [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'password' => bcrypt('Elipse#1126'),
                    'type' => 'system',
                ],
                [
                    'name' => 'Pra Viajar',
                    'email' => 'admin@praviajar.com.br',
                    'password' => bcrypt('@LogPvj1126'),
                    'type' => 'admin',
                ]
            )
        );
    }
}
