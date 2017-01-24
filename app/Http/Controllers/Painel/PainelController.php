<?php

namespace App\Http\Controllers\Site;
use App\Http\Controllers\Controller;

class PainelController extends Controller {
    function index(){
        return 'Painel!!!';
        //return view('Painel.painel');
    }

    function hello($nome){
        return view('Painel.painel');
    }
}