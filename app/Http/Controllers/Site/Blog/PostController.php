<?php

namespace App\Http\Controllers\Site\Blog;

use App\City;
use App\Http\Controllers\Controller;
use App\Library\BlogJobs;
use App\Library\Jobs;
use App\Library\WorldEstructureJobs;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    use Jobs;
    use WorldEstructureJobs;
    use BlogJobs;

    public $model;

    public function __construct()
    {
        $this->model = new Post();
        $this->json_meta(['contentToolsOnSave' => 'post.create']);
        $this->vars['isNew'] = true;
        $this->vars['isAdmin'] = Auth::check();
    }

    public function city($id)
    {
        //Se q requisição for request, é criação de post para cidade ainda não existente no banco
            $this->json_meta(['from' => 'city']);

        //Para cidades ainda não cadastradas no banco.
        if ($id instanceof Request)
        {
            $this->json_meta(['request' => $id->all()]);
            $this->getEstructureBreadcrumb('city', $id);
        }
        //Para cidades já cadastradas.
        else
        {
            $this->json_meta(['id' => $id]); //id da cidade

            $city = City::where('id', $id)->first();
            $this->getEstructureBreadcrumb('city', $city);
        }

        return view('Site.blog.post_city', $this->vars);
    }

    public function readCityPost($post_id){
        //Caso seja usuário autenticado visitante post no site, também será possível editar.
        $this->json_meta(['contentToolsOnSave' => 'post.update']);
        $this->json_meta(['from' => 'city']);
        $this->json_meta(['post_id' => $post_id]);

        //Ler post
        $post = Post::where('id', $post_id)->first();
        $this->vars['isNew'] = false;
        BlogJobs::manage($post);
        $this->vars['post'] = $post;
        $this->getEstructureBreadcrumb('city', $post->City->first()->id);

//        $this->vars['isAdmin'] = false;
        if ( $post->status != 'ativo' )
        {
            if ($this->vars['isAdmin'])
            {
                return view('Site.blog.post_city', $this->vars);
            }
            else
            {
                return view('Site.404', $this->vars);
            }
        }
        else
        {
            return view('Site.blog.post_city', $this->vars);
        }
    }
}