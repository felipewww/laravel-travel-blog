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

//Rotas do Site
Route::get('/', 'Site\IndexController@index');

/*
 * Rotas apenas se não estiver logado
*/
Route::group(['middleware' => 'guest'], function (){

    Route::group(['prefix' => 'auth'], function (){
        Route::get('register', 'Auth\RegisterController@view');
        Route::post('register', 'Auth\RegisterController@register');

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

});

/*
 * Rotas para páginas do Painel admin
 * */
Route::group(['middleware' => 'auth'], function (){
    Route::group(['prefix' => 'painel'], function (){
        Route::get('/mundo/pais', 'Painel\World\CountryController@display');
        Route::post('/mundo/pais', 'Painel\World\CountryController@store');

        Route::get('', 'Painel\IndexController@index');

        Route::any('logout', 'Auth\LoginController@logout');
    });
});