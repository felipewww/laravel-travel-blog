<?php

namespace App\Http\Controllers\Painel\Blog;

use App\Library\DataTablesInterface;
use App\Library\DataTablesExtensions;
use \App\Http\Controllers\Controller;
use App\Library\Jobs;
use App\Post;

class PostsController extends Controller implements DataTablesInterface
{
    use Jobs;
    use DataTablesExtensions;

    protected $model;
    public $all;

    public function __construct()
    {
        $this->model = new Post();
        $this->getAll();
        $this->dataTablesInit();

        $this->vars['modulo'] = 'Blog';
        $this->vars['pageDesc'] = 'Todos os Posts';
    }

    public function getAll()
    {
        $this->all = $this->model->all();

        $final = [];
        foreach ($this->all as $post)
        {
            $reg = $post->getAttributes();

            //$reg['author_name'] = $post->author->user->name;
            $reg['author_name'] = ( empty($reg['author_id']) ) ? 'Sem autor' : $post->author->user->name;
//            dd($post->author->user->name);
            array_push($final, $reg);
        }

        $this->all = $final;
    }

    public function dataTablesConfig()
    {
        $data = [];
        $i = 1;

        foreach ($this->all as $reg)
        {
            $cInfo = [
                $i,
                $reg['id'],
//                $reg['title'],
                $reg['author_name'],
            ];
            array_push($data,$cInfo);
            $i++;
        }

        $this->data_info = $data;

        $this->data_cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '40px'],
//            ['title' => 'titulo'],
            ['title' => 'Autor', 'width' => '150px'],
        ];
    }

    public function view(){
        return view('Painel.blog.posts', $this->vars);
    }

    public function display()
    {
        $this->dataTablesInit();
//        $this->vars['data'] = $this->all;
        return view('Painel.interests.interests', $this->vars);
    }
}
