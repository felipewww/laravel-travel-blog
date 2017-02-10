<?php

namespace App\Http\Controllers\Site\Blog;

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
        if ($id instanceof Request) {
//        dd($id);
            //Para cidades ainda não cadastradas no banco.
            $this->json_meta(['request' => $id->all()]);
        }else{
            //Para cidades já cadastradas.
            $this->json_meta(['id' => $id]);
        }

        $this->json_meta(['from' => 'city']);
        $this->getEstructureBreadcrumb('city', $id);

        return view('Site.blog.post_city', $this->vars);
    }

    public function editPostCity($id){
        $this->json_meta(['contentToolsOnSave' => 'post.update']);
        $this->json_meta(['post_id' => $id]);
        $this->vars['isNew'] = false;
        $posts = $this->model->where('id',$id)->get();

//        dd($post);
//        $this->getEstructureBreadcrumb('city', $post[0]->polimorph_from_id);
        $this->getEstructureBreadcrumb('city', $posts[0]->polimorph_from_id);

        $this->vars['post'] = BlogJobs::manage($posts)[0];
        return view('Site.blog.post_city', $this->vars);
    }
}