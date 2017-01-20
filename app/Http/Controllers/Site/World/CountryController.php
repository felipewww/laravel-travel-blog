<?php

namespace App\Http\Controllers\Site\World;

use App\Http\Controllers\Controller;
use App\Library\Jobs;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller {
    use Jobs;

    function index(){
        return view('Site.world.country', ['isAdmin' => Auth::check()]);
    }
}