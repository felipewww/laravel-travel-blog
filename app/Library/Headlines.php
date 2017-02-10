<?php

namespace  App\Library;

trait Headlines {
    public function __construct($from, $id = null)
    {
        if ( isset($this->reg) && !empty($this->reg) )
        {
            $id = $this->reg->id;
        }
        else
        {
            if (is_null($id)) {
                throw new \ErrorException('Para montar o REG a partir de Headlines, é necessário informar o ID do registro');
            }

            if ( !isset($this->model) ) {
                $this->model = new $from();
            }

            $this->reg = $this->model->find($id);
        }

        $this->json_meta([
            'headline_morph' => [
                'from' => $from,
                'reg_id' => $id
            ]
        ]);

        $this->vars['headlines'] = $this->reg->Headline;
    }
}