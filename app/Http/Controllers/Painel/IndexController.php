<?php

namespace App\Http\Controllers\Painel;
use App\Http\Controllers\Controller;

class IndexController extends Controller  {
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vars = [
            'modulo' => 'PAINEL',
            'pageDesc' => 'Home'
        ];

        return view('Painel.index', $vars);
    }
}