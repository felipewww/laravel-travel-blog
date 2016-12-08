<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/painel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest', ['except' => 'logout']);
    }

//    public function username()
//    {
//        return 'username';
//    }

    public function view(Request $request){
        if ( $request->isMethod('post') ){
            $credentials = $request->only('password','email');

//            if (Auth::check()){
//                return Redirect::to('/painel');
//            }
//            if(!Auth::attempt($credentials)){
//                echo 'FALSE!';
//                //return redirect()->back()->with('fail', 'Dados errados ou não encontrados');
//            }else{
//                echo 'TRUE';
//            }
        }

        return view('auth.login');
    }
}
