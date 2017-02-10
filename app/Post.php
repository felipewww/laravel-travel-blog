<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Faker;

class Post extends Model
{
    protected $fillable = ['content_regions', 'status', 'post_type_id', 'author_id'];

    /*
     * criar headline do post
     * */
    public function Headline()
    {
        return $this->morphMany(Headline::class, 'headline_morph');
    }

    public function polimorph_from()
    {
        return $this->morphTo();
    }

    public function author() { return $this->belongsTo('App\Authors'); }
    public function post_type() { return $this->belongsTo('App\PostType'); }

    /*Polimorphics*/
//    public function polimorph_from(){
//
//    }
    /*Polimorphics*/

    /*
     * examples:
     * -> Painel\Post::generateFake('Cities:make', ['title' => 'titleTest'], 3)
     * -> Painel\Post::generateFake('Cities:create', 3)
     * */
    public static function generateFake($from, $attributes = [], $qtt = 1)
    {
        /** tratar $from e $action*/
        $f = explode(':',$from);
        $from       = $f[0];
        $action     = ( isset($f[1]) ) ? $f[1] : 'make';

        /** tratar attributes e qtt*/
        if (!is_array($attributes))
        {
            if (is_int($attributes)){ $qtt = $attributes; }
            $attributes = [];
        }

        if ( empty($attributes) ) { $attributes['random_date'] = true; }

        if ( $attributes['random_date'] )
        {
            $faker = Faker\Factory::create();

            $attributes['updated_at'] = $faker->date().' '.$faker->time();
            $attributes['created_at'] = $faker->date().' '.$faker->time();
        }

        unset($attributes['random_date']);

        /** Actions */
        if ($action == 'make'){
            return factory('Painel\World\Post', $qtt)->states($from)->make($attributes);
        }else if($action == 'create'){
            return factory('Painel\World\Post', $qtt)->states($from)->create($attributes);
        }else{
            return trigger_error('Action "'.$action.'" not be found.', E_USER_ERROR);
        }

    }

    public static function defaultFakeFields($from)
    {
        return [
            'polimorph_from_id'     => $from::all()->random(1)->id,
            'polimorph_from_type'   => $from
        ];
    }
}
