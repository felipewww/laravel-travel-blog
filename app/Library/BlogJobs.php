<?php

namespace App\Library;

use App\City;
use App\Country;
use App\Post;

trait BlogJobs {

    /*
     * Tratamento defualt de dados para exibição
     * */
    private static $callbacks = [
        'author_id' => true,
        'status' => true,
        'created_at' => true,
    ];

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
            //return $posts[0];
        }else{
//            return $posts;
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

//        if ($post->polimorph_from_type == City::class)
//        {
//            $city       = $post->polimorph_from;
//            $country    = $city->estate->country;
//            $data['city'] = $city->name;
//            $data['country'] = $country->name;
//
//            $post->urlGoback = '/painel/mundo/cidade/'.$city->id;
//            $post->nameGoback = $city->name;
//            $post->siteUrl = '/blog/c/'.$titleAscii.'/'.$post->id;
//        }
//        else if($post->polimorph_from_type == Country::class)
//        {
//            $country       = $post->polimorph_from;
//            $data['country'] = $country->name;
//            $post->urlGoback = '/painel/mundo/pais/'.$country->id;
//            $post->nameGoback = $country->name;
//            $post->siteUrl = '/blog/p/'.$titleAscii.'/'.$post->id;
//        }

        if ($post->polymorphic_from == City::class)
        {
//            dd($post->City->first());
//            $city       = $post->polymorph_from;
            $city       = $post->City->first();
            $country    = $city->estate->country;
            $data['city'] = $city->name;
            $data['country'] = $country->name;

            $post->urlGoback = '/painel/mundo/cidade/'.$city->id;
            $post->nameGoback = $city->name;
            $post->siteUrl = '/blog/c/'.$titleAscii.'/'.$post->id;
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