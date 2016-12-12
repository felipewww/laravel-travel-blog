<?php

namespace App\Models\Painel;

use App\Models\Painel\Post;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function Post()
    {
        return $this->morphMany(Post::class, 'polimorph_from');
    }
}
