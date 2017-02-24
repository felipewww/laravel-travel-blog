<?php

namespace  App\Library;

use App\Interest;
use Illuminate\Http\Request;

trait Interests {
    public function __construct()
    {
        $selecteds = [];
        foreach ($this->reg->Interests as $selected)
        {
            array_push($selecteds, $selected->id);
        }

        $allInterests = Interest::all();
        foreach ($allInterests as &$all)
        {
            $all['checked'] = (array_search($all->id, $selecteds) !== false) ? 'checked="checked"' : '';
        }

        $this->vars['interests'] = $allInterests;
        return $allInterests;
    }

    public function updateInterests($request)
    {
        $this->reg->Interests()->sync($request->ints);

        return [
            'message' => [
                'type' => 'success', 'title' => 'Feito!', 'text' => 'Interesses atualizados com sucesso.'
            ]
        ];
    }
}