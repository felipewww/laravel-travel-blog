<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;

//Rotas do Site
Route::get('/', 'Site\IndexController@index');

/*
 * Rotas apenas se não estiver logado
*/
Route::get('pais/{nome}/{id}', ['uses' => 'Site\World\CountryController@index']);
Route::get('estado/{nome}/{id}', ['uses' => 'Site\World\EstateController@index']);
Route::get('cidade/{nome}/{id}', ['uses' => 'Site\World\CityController@fromDB']);

Route::post('upload-image', 'Site\IndexController@uploadImage');
Route::post('insert-image', 'Site\IndexController@insertImage');

Route::group(['prefix' => 'auth'], function (){
    Route::get('login', 'Auth\LoginController@view');
    Route::post('login', 'Auth\LoginController@login');

    Route::get('reset', 'Auth\ResetPasswordController@showResetForm');
    Route::post('reseted', 'Auth\ResetPasswordController@reset');

    // Password Reset Routes...
    $this->get('reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    $this->post('reset', 'Auth\ResetPasswordController@reset');
});

/*
 * Rotas para páginas do Painel admin
 * */

Route::group(['middleware' => 'auth'], function (){

    Route::group(['prefix' => 'tinker'], function (){
        Route::get('', 'Dev\IndexController@index');
        Route::get('/{action}', ['uses' => 'Dev\IndexController@index']);
    });

    Route::group(['prefix' => 'painel'], function (){

        Route::group(['middleware' => 'api'], function (){
            Route::get('/api/mundo/pais/{action}', ['uses' => 'Painel\World\CountryController@apiAction']);

            Route::post('/api/blog/cidade/save/{id}', function (\Illuminate\Http\Request $request, $cityId){
                $c = new \App\Http\Controllers\Painel\World\CityController($cityId);
                return $c->apiAction($request);
            });

            Route::post('/api/mundo/cidade/{id}', function (\Illuminate\Http\Request $request, $cityId){
                $c = new \App\Http\Controllers\Painel\World\CityController($cityId);
                return $c->apiAction($request);
            });

        });

        Route::group(['prefix' => 'blog'], function (){
            Route::post('cidade', 'Site\World\CityController@forCreate');
            Route::get('cidade/{id}', ['uses' => 'Site\World\CityController@fromDB']);
        });

        Route::group(['prefix' => 'mundo'], function (){

            Route::get('paises', 'Painel\World\CountriesController@display');

            Route::group(['prefix' => 'pais'], function(){
//                Route::get('', 'Painel\World\CountryController@display');
                Route::get('{id}', ['uses' => 'Painel\World\CountryController@display']);

            });

            Route::group(['prefix' => 'cidade'], function(){
                Route::get('{id}', function ($id){
                    $c = new \App\Http\Controllers\Painel\World\CityController($id);
                    return $c->display();
                });
            });

        });

        Route::group(['prefix' => 'interesses'], function (){
            Route::get('', 'Painel\Interests\InterestController@display');
        });

        Route::get('', 'Painel\IndexController@index');
        Route::any('logout', 'Auth\LoginController@logout');

        Route::get('register', 'Auth\RegisterController@view');
        Route::post('register', 'Auth\RegisterController@register');
    });
});