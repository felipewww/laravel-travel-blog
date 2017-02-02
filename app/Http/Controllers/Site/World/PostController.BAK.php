<?php

namespace App\Http\Controllers\Site\World;

use App\Http\Controllers\Controller;
use App\Library\Jobs;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    use Jobs;

    public function __construct()
    {
        $this->json_meta(['contentToolsOnSave' => 'post.create']);
        $this->vars['isNew'] = true;
        $this->vars['isAdmin'] = Auth::check();
    }

    public function city($id)
    {
        $this->json_meta(['from' => 'city']);
        $this->json_meta(['id' => $id]);
        $this->getEstructureBreadcrumb('city', $id);

        return view('Site.blog.post_city', $this->vars);
    }
}