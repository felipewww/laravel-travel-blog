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
            array(
                ['name' => 'post'],
                ['name' => 'lista'], //lista talvez saira daqui, tera uma tabela especifica de lista
                ['name' => 'patrocinado']
            )
        );
    }
}
