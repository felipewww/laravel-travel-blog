<?php

namespace App\Http\Controllers\Site\World;

use App\Http\Controllers\Controller;
use App\Library\Jobs;
use Illuminate\Support\Facades\Auth;

class EstateController extends Controller {
    use Jobs;

    function index(){
        return view('Site.world.estate', ['isAdmin' => Auth::check()]);
    }
}