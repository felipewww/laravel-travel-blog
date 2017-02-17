<?php

namespace  App\Library;

use App\Headline;
use App\Http\Controllers\Painel\Blog\PostController;
use App\Http\Controllers\Painel\Places\PlaceController;
use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

trait Headlines {
    public function __construct($from, $id = null)
    {
        $this->vars['from'] = $from;

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

        $this->vars['reg'] = $this->reg;

        $this->json_meta([
            'headline_morph' => [
                'from' => $from,
                'reg_id' => $id
            ]
        ]);

        $this->vars['headlines'] = $this->reg->Headlines;
    }

    public static function defineAndCreateHeadline(Request $request)
    {
        $reg_id = $request->reg_id;

        switch ($request->from)
        {
            case \App\City::class:
                $c = new \App\Http\Controllers\Painel\World\CityController($reg_id);
                $url = '/painel/mundo/cidade/'.$reg_id;
                $folder = 'cidades';
                break;

            case \App\Country::class:
                $c = new \App\Http\Controllers\Painel\World\CountryController($reg_id);
                $url = '/painel/mundo/pais/'.$reg_id;
                $folder = 'paises';
                break;

            case \App\Post::class:
                $c = new PostController($reg_id);
                $url = '/painel/blog/post/'.$reg_id;
                $folder = 'postContent';
                break;

            case Place::class:
                $c = new PlaceController($reg_id);
                $url = '/painel/servicos/servico/'.$reg_id;
                $folder = 'places';
                break;

            default:
                throw new Error('Falta model $from');
                break;
        }

        $msg = $c->createOrUpdateHeadline($request, $folder);
        return redirect($url)->with('PostMessage', json_encode($msg));
    }

    public function createOrUpdateHeadline(Request $request, $folder){
        $text = false;
        if ( isset($request->hl_new) ) {
            foreach ($request->hl_new as $hl){
                $img = $this->uploadHeadlineImage($hl['img'], $folder);

                $data = [
                    'title' => $hl['title'],
                    'content' => $hl['text'],
                    'src' => $img->fullpath,
                    'polymorphic_from' => $request->from
                ];
                $this->reg->Headlines()->create($data);
            }
            $text   = 'Headlines criados com sucesso.';
        }

        if ( isset($request->hl) ) {
            foreach ($request->hl as $id => $hl){
                $hl_reg = Headline::where('id', $id)->first();
                $data = [];

                if ( !empty($hl['title']) ) { $hl_reg->title = $hl['title']; }
                if ( !empty($hl['text']) ) { $hl_reg->content = $hl['text']; }

                //Deletar imagem antiga
                if ( isset($hl['img']) ) {
                    $imgToUnlink = public_path($hl_reg->src);
                    unlink($imgToUnlink);

                    $img = $this->uploadHeadlineImage($hl['img'], $folder);
                    $hl_reg->src = $img->fullpath;
                }

                if ( !empty($data) ) {
                    $this->reg->Headline()->create($data);
                }
                $hl_reg->save();
            }
            $text = ( $text ) ? 'Headlines criados e alterados com sucesso.': 'Headlines alterados com sucesso.';
        }

        if (!$text) {
            $type   = 'info';
            $title  = 'Nenhuma alteração.';
            $text   = 'Nenhum erro, nem alteração!';
        }else{
            $type   = 'success';
            $title  = 'Feito!';
        }

        $PostMessage =  [
            'type' => $type, 'title' => $title, 'text' => $text
        ];

        return $PostMessage;
    }

    /*
     * Default de crop da imagem do sistema.
     * É possível sobrepor este método diretamente na controller.
     * */
    protected function uploadHeadlineImage($img, $folder){
        return $img = Jobs::uploadImage($img, "Site/media/images/$folder/headlines",
            [
                'shape' => 'square',
                'max-width' => 400,
            ]
        );
    }
}