<?php

namespace App\Library;

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

            $post['managed_regions'] = $postRegions;
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
}