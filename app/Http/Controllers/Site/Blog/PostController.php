<?php

namespace App\Http\Controllers\Site\Blog;

use App\City;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Painel\World\CityController;
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
        $this->vars['isAdmin'] = Auth::check();
    }

    public function city($id)
    {
        $request = Request::capture()->all();
        $city = new CityController($id);

        if ( isset($request['action']) ) {
            switch ($request['action'])
            {
                case 'create':
                    $res = $city->createPost($request);
                    break;

                case 'update':
                    $res = $city->updatePost($request);
                    break;

                default:
                    throw new \Error('Falta action');
                    break;
            }

            return $res;
        }

        $this->vars['isNew'] = true;
//        $this->getEstructureBreadcrumb('city', $city);
        return view('Site.blog.post_city', $this->vars);
    }

    public function readCityPost($post_id){

        $request = Request::capture()->all();
//        dd($request);
        if ( isset($request['action']) )
        {
            $ctrl = new CityController(0);
            return $ctrl->updatePost($post_id, $request);
        }

        //Caso seja usuário autenticado visitando post no site, será possível editar.
        $this->json_meta(['contentToolsOnSave' => 'post.update']);
        $this->json_meta(['from' => 'city']);
        $this->json_meta(['post_id' => $post_id]);

        //Ler post
        $post = Post::where('id', $post_id)->first();
        $this->vars['isNew'] = false;
        BlogJobs::manage($post);
        $this->vars['post'] = $post;
//        $this->getEstructureBreadcrumb('city', $post->City->first()->id);

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