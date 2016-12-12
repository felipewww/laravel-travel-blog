<?php

use Illuminate\Database\Seeder;

class PostsTypes extends Seeder
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
            ['name' => 'post'],
            ['name' => 'lista'],
            ['name' => 'patrocinado']
        );
    }
}
