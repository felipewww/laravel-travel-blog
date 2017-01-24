<?php

//namespace app\Models\Painel;
//namespace Painel\World;
namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;
    public $fillable = ['name', 'sigla_2', 'sigla_3'];
    public $sigla_2 = null;

    public function Headline()
    {
        return $this->morphMany(Headline::class, 'polimorph_from');
    }

    public function Post()
    {
        return $this->morphMany(Post::class, 'polimorph_from');
    }

    public function generateFakePost($city_id = false, $quantity = 1)
    {
        Post::generateFake($city_id);
    }

    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continents_id');
    }

    /**
     * @see App/Exceptions/PDO [If ->create() returns PDOException]
     * @param array $post [Request $_POST from controller]
     * @return boolean
     */
    public function store($post)
    {
        $c          = new Continent();
        $continent  = $c->find((int)$post['continents_id']);

        if ($continent){
            $continent->country()->create($post);
            return true;
        }else{
            return false;
        }
    }
}