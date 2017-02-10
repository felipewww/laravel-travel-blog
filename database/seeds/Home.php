<?php

use Illuminate\Database\Seeder;

class Home extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('homes')->insert
        (
            array(
                [
                    'description' => 'Homepage 0'
                ],
            )
        );
    }
}
