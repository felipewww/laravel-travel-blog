<?php

namespace App\Http\Controllers\Dev;
use Illuminate\Http\Request;

class IndexController extends \App\Http\Controllers\Controller {

    public function index($action)
    {
        $this->$action();
    }
}