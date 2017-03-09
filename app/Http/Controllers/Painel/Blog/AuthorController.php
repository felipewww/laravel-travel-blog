<?php

namespace App\Http\Controllers\Painel\Blog;

use App\Library\DataTablesInterface;
use App\Library\DataTablesExtensions;
use \App\Http\Controllers\Controller;
use App\Library\Jobs;
use App\Authors;
use Illuminate\Http\Request;

class AuthorController extends Controller implements DataTablesInterface
{
    use Jobs;
    use DataTablesExtensions;

    public $all;

    public function __construct()
    {
        $this->model = new Authors();
        $this->getAll();
        $this->dataTablesInit();

        $this->vars['modulo'] = 'Blog';
        $this->vars['pageDesc'] = 'Autores de Posts';
    }

    public function getAll()
    {
        $this->all = $this->model->all();

        $final = [];
        foreach ($this->all as $author)
        {
            $reg = $author->getAttributes();
            $reg['name'] = $author->user->name; //belongsTo
            array_push($final, $reg);
        }

        $this->all = $final;
    }

    /**
     * @see UserController - da página de usuario é possivel setar o user como AUTOR utilizando essa função
     * */
    public function defineAuthorAjaxAction(Request $request)
    {
        $res = ['status' => false];

        $user = \App\User::where('id', $request->id)->get()[0]->getAttributes();

        if ($user['photo'] == null) {
            $user['photo'] = '/Site/media/images/autores/default.png';
        }

        $newAuthor = $this->model->create([
            'photo' => $user['photo'],
            'user_id' => $user['id'],
            'description' => 'Aqui vem a descrição do autor',
        ]);

        if ( isset($newAuthor->id) ) {
            $res['author'] = $newAuthor;
            $res['status'] = true;
        }

        return json_encode($res);
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
                $reg['name'],
                0,
            ];
            array_push($data,$cInfo);
            $i++;
        }

        $this->data_info = $data;

        $this->data_cols = [
            ['title' => 'n', 'width' => '10px'],
            ['title' => 'id', 'width' => '40px'],
            ['title' => 'nome'],
            ['title' => 'posts'],
        ];
    }

    public function view(){
        return view('Painel.blog.authors', $this->vars);
    }

    public function display()
    {
        $this->dataTablesInit();
//        $this->vars['data'] = $this->all;
        return view('Painel.interests.interests', $this->vars);
    }
}
