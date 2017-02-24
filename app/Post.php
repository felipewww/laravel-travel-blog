<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Faker;

class Post extends Model
{
    protected $fillable = ['content_regions', 'status', 'post_type_id', 'author_id', 'polymorphic_from'];

    /*
     * Acima temos o polyumorphic do laravel, que não atende a necessidade.
     * Criar função para ler registros a partir do polimorfismo
     * o mesmo de HEADLINE e EVENT
     * */
    public function polymorphic_from(){
        //todo
    }

    public function City()
    {
        return $this->belongsToMany(City::class, 'cities_has_posts', 'post_id', 'city_id');
    }

    public function Headlines()
    {
        return $this->belongsToMany(Headline::class, 'posts_has_headlines', 'post_id', 'headline_id');
    }

    public function Photos()
    {
        return $this->hasMany(PostPhotos::class);
    }

    public function author() { return $this->belongsTo('App\Authors'); }
    public function PostType() { return $this->belongsTo('App\PostType'); }

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
