<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class Authors extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('authors')->insert(
            array
            (
                [
                    'users_id' => 1,
                    'description' => $faker->paragraph
                ],
                [
                    'users_id' => 2,
                    'description' => $faker->paragraph
                ],
                [
                    'users_id' => 3,
                    'description' => $faker->paragraph
                ],
                [
                    'users_id' => 4,
                    'description' => $faker->paragraph
                ],
            )
        );
    }
}
