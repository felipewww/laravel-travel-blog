<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(Interests::class);
        $this->call(WorldEstructureSeeder::class);
        $this->call(PostsTypes::class);
        $this->call(Authors::class);
//        $this->call(Places::class);
        $this->call(Home::class);
        $this->call(UnitedKingdomSeeder::class);
    }
}
