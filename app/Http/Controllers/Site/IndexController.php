<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller {
    function index(){
        return 'view(Site.index)';
        //return view('Site.index');
    }

    function hello($nome){
        $html = '<b>HTML</b>';
        return view('Site.index', ['nome' => $nome, 'html' => $html]);
    }

    public function pais(Request $request){
        return view('Site.cidade', ['isAdmin' => Auth::check()]);
    }

    public function estado(Request $request){
        return view('Site.cidade', ['isAdmin' => Auth::check()]);
    }

    public function cidade(Request $request){
        return view('Site.cidade', ['isAdmin' => Auth::check()]);
    }


    public function uploadImage(Request $request)
    {
        if ( $request->hasFile('image') ) {
            $base_path = base_path() . '/public';
            $path = '/Site/media/images/postContent/';

            $file = $request->file('image');
            $newName = time().'.'.$file->getClientOriginalExtension();

            $file->move($base_path.$path, $newName);

            $size = getimagesize($base_path.$path.$newName);
//            dd($x);

            echo json_encode([
                'url' => $path.$newName,
                'size' => [$size[0], $size[1]]
            ]);
        }else{
            trigger_error('Erro. $_FILES não existe', E_USER_ERROR);
        }
    }

    public function insertImage(){

    }
}