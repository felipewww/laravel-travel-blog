<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;
use Faker;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = ['title','content','content_str'];
    
    public function polimorph_from()
    {
        return $this->morphTo();
    }

    public function insertFake()
    {
        $faker = Faker\Factory::create();

//        DB::table("posts")->insert([
//            'title' => $faker->text(),
//            'content' => $faker->paragraph(15),
//            'content_strip' => $faker->text(),
//            'updated_at' => $faker->date().' '.$faker->time(),
//            'created_at' => $faker->date().' '.$faker->time(),
//            'polimorph_from_id' => 1,
//            'polimorph_from_type' => $faker->text(),
//            'post_type_id' => 1,
//        ]);

        $this->title                = $faker->text();
        $this->content              = $faker->paragraph(15);
        $this->content_strip        = $faker->text();
        $this->updated_at           = $faker->date().' '.$faker->time();
        $this->created_at           = $faker->date().' '.$faker->time();
        $this->polimorph_from_id    = 1;
        $this->polimorph_from_type  = $faker->text();
        $this->post_type_id         = 1;
    }
}
