<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends \App\Http\Controllers\Controller {
    function index(){
        return 'view(Site.index)';
        //return view('Site.index');
    }

    function hello($nome){
        $html = '<b>HTML</b>';
        return view('Site.index', ['nome' => $nome, 'html' => $html]);
        //return view('auth.register');
    }

    public function cidade(Request $request){
        return view('Site.cidade', ['isAdmin' => Auth::check()]);
    }
}