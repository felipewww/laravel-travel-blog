<?php

namespace App\Models\Painel;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function Post()
    {
        return $this->morphMany(Post::class, 'polimorph_from');
    }
}
