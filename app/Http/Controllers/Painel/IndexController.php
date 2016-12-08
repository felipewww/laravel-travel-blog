<?php

namespace App\Http\Controllers\Painel;
use Illuminate\Http\Request;

class IndexController extends \App\Http\Controllers\Controller {
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Painel.index');
    }
}