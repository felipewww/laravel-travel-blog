<?php

use Illuminate\Database\Seeder;

class Places extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_types')->insert
        (
            array(
                ['name' => 'post'],
                ['name' => 'lista'],
                ['name' => 'patrocinado']
            )
        );
    }
}
