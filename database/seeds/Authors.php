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
                    'user_id' => 1,
                    'description' => $faker->paragraph,
                    'photo' => '/public/author.png'
                ],
                [
                    'user_id' => 2,
                    'description' => $faker->paragraph,
                    'photo' => '/public/author.png'
                ],
                [
                    'user_id' => 3,
                    'description' => $faker->paragraph,
                    'photo' => '/public/author.png'
                ]
            )
        );
    }
}
