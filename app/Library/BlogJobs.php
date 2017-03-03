<?php

namespace App\Library;

use App\City;
use App\Country;
use App\Post;

trait BlogJobs {

    public $postButtons;
//    public static $caller;
    /*
     * Tratamento defualt de dados para exibição
     * */
    private static $callbacks = [
        'author_id' => true,
        'status' => true,
        'created_at' => true,
    ];

    public function __construct()
    {
        if ( !isset($this->model) ) {
            throw new \Error('Obrigatório "$this->model" para ler BlogJobs');
        }

        $this->vars['postButtons'] = $this->createPostButtons();
    }

    protected function createPostButtons()
    {
        $actButtons = new \stdClass();
        switch ($this->caller)
        {
            case City::class:
                $url = 'cidade';
                break;

            case Country::class:
                $url = 'pais';
                break;

            default:
                throw new \Error('$this->caller não identificado');
            break;
        }

        $actButtons->createPostButton = "/painel/blog/novo-post/$url/".$this->reg->id;
        $actButtons->editPostButton = "/painel/blog/edit-post/$url/";

        return $actButtons;
    }
    /*
     * Gerencia um objeto de posts
     * */
    public static function manage(&$posts, $callbacks = [])
    {
        $isInstance = false;
        //Se for um post em especifico, não uma listagem de post...
        if ($posts instanceof Post) {
            $posts = [$posts];
            $isInstance = true;
        }

        /*
         * Manter callbacks default e adicionar os definidos do programador...
         * */
        if (!empty($callbacks)) {
            foreach ($callbacks as $k => $call)
            {
                self::$callbacks[$k] = $call;
            }
        }
        $callbacks = self::$callbacks;

        foreach ($posts as &$post)
        {
            $postRegions = [];
            $regions = json_decode($post['content_regions'], true);
            foreach ($regions as $name => $content)
            {
                $postRegions[$name] = $content;
            }

            $post['managed_regions'] = $postRegions;
            /*
             * funções para tratar os dados a serem exibidos
             * */
            foreach ($callbacks as $key => $call)
            {
                switch (strtolower(gettype($callbacks[$key])))
                {
                    case 'object':
                        call_user_func_array($call, [$post, $post[$key]]);
                        break;

                    case 'boolean' && $call == true:
                        self::$key($post, $post[$key]);
                        break;
                }
            }

        }

        if ($isInstance) {
            $posts = $posts[0];
        }

        return $posts;
    }

    public static function status($post, $status)
    {
        $post->status = ( $status ) ? 'ativo' : 'inativo';
    }

    public static function created_at($post, $created_at)
    {
        //todo
    }

    public static function author_id($post, $author_id)
    {
        if ( !$author_id )
        {
            $info = [
                'name' => 'Sem autor'
            ];
        }
        else
        {
            $info = $post->Author->getAttributes();
            $info['name'] = $post->Author->user->name;
        }

        $post['author'] = $info;
    }

    /**
     * função que pode ser chamada com callback = [title => true]
     * */
    public static function title($post){
        $regions = json_decode($post->content_regions);
        $post->title = $regions->article_title->content;
    }

    public static function getPolimorphInfo($post)
    {
        $data = [];
        $post->polyinfo = new \stdClass();

        $titleAscii = Jobs::_toAscii($post->managed_regions['article_title']['content']);

        if ($post->polymorphic_from == City::class)
        {
            $city       = $post->City->first();
            $country = $city->Country;
            $data['city'] = $city->name;
            $data['country'] = $country->name;

            $post->urlGoback = '/painel/mundo/cidade/'.$city->id;
            $post->nameGoback = $city->name;
            //$post->siteUrl = '/blog/c/'.$titleAscii.'/'.$post->id;
            $post->siteUrl = '/painel/blog/edit-post/cidade/'.$post->id;
        }
        else if($post->polymorphic_from == Country::class)
        {
            $country       = $post->polimorph_from;
            $data['country'] = $country->name;
            $post->urlGoback = '/painel/mundo/pais/'.$country->id;
            $post->nameGoback = $country->name;
            $post->siteUrl = '/blog/p/'.$titleAscii.'/'.$post->id;
        }

        $post->polyinfo->breadcrumb = $data;
    }
}