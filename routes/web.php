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
 * Rotas para páginas do site
*/
Route::get('pais/{nome}/{id}', ['uses' => 'Site\World\CountryController@index']);
Route::get('estado/{nome}/{id}', ['uses' => 'Site\World\EstateController@index']);
Route::get('cidade/{nome}/{id}', ['uses' => 'Site\World\CityController@fromDB']);

//Route::get('/blog/c/{titulo}/{id}', function ($titulo, $id){
//    $c = new App\Http\Controllers\Site\Blog\PostController();
//    return $c->city($id);
//});

Route::get('/blog/c/{titulo}/{id}', function ($titulo, $id){
    $c = new App\Http\Controllers\Site\Blog\PostController();
    return $c->readCityPost($id);
});

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

        Route::post('createOrUpdateHeadline', function (\Illuminate\Http\Request $request){
            return \App\Library\Headlines::defineAndCreateHeadline($request);
        });

        Route::group(['middleware' => 'api'], function (){

            Route::group(['prefix' => '/api/headline'], function (){

                Route::post('deleteHeadline', function (\Illuminate\Http\Request $request){
                    $c = new \App\Http\Controllers\Painel\HeadlineController();
                    return $c->deleteHeadline($request);
                });
            });

            Route::post('/api/home/getHeadlines', function (\Illuminate\Http\Request $request){
                return \App\Http\Controllers\Site\IndexController::getHeadlinesApi($request);
            });

            Route::post('/api/home/updateHeadlines', function (\Illuminate\Http\Request $request){
                $c = new \App\Http\Controllers\Site\IndexController();
//                return \App\Http\Controllers\Site\IndexController::updateHeadlinesApi($request);
                return $c->updateHeadlinesApi($request);
            });

            Route::get('/api/mundo/pais/{action}', ['uses' => 'Painel\World\CountryController@apiAction']);

            Route::post('/api/blog/cidade/save/{id}', function (\Illuminate\Http\Request $request, $cityId){
                $c = new \App\Http\Controllers\Painel\World\CityController($cityId);
                return $c->apiAction($request);
            });

            Route::post('/api/blog/post/cidade', function (\Illuminate\Http\Request $request){
//                $id = $request->screen_json['post_id'] ?? $request->screen_json['request']['city']['geonameId'];
                $id = $request->screen_json['post_id'] ?? 0;

                $c = new \App\Http\Controllers\Painel\Blog\PostController($id);
                return $c->apiAction($request);
            });

            Route::post('/api/mundo/cidade/{id}', function (\Illuminate\Http\Request $request, $cityId){
                $c = new \App\Http\Controllers\Painel\World\CityController($cityId);
                return $c->apiAction($request);
            });

            Route::post('/api/usuarios', function (\Illuminate\Http\Request $request){
                $c = new \App\Http\Controllers\Painel\Blog\AuthorController();
                return $c->apiAction($request);
            });
        });

        Route::group(['prefix' => 'blog'], function (){
            Route::get('novo-post/cidade/{id}', function ($id){
                $c = new App\Http\Controllers\Site\Blog\PostController();
                return $c->city($id);
            });

            //novo post para cidade não existente
            Route::post('post/cidade', function (\Illuminate\Http\Request $request){
                $c = new \App\Http\Controllers\Site\Blog\PostController();
                return $c->city($request);
            });

            Route::get('post/cidade/{id}', function ($id){
                $c = new App\Http\Controllers\Site\Blog\PostController();
                return $c->readCityPost($id);
            });

            Route::get('posts', ['uses' => 'Painel\Blog\PostsController@view']);
            Route::get('post/{id}', function ($id){
                $c = new \App\Http\Controllers\Painel\Blog\PostController($id);
                return $c->view();
            });

            Route::get('autores', ['uses' => 'Painel\Blog\AuthorController@view']);
            Route::get('autor/{id}', ['uses' => 'Painel\Blog\AuthorController@viewAuthor']);
        });

        Route::group(['prefix' => 'mundo'], function (){

            Route::get('paises', 'Painel\World\CountriesController@display');

            Route::group(['prefix' => 'pais'], function(){
                Route::get('{id}', ['uses' => 'Painel\World\CountryController@display']);
            });

            Route::group(['prefix' => 'cidade'], function(){
                Route::post('single', 'Site\World\CityController@forCreate');
//                Route::get('single/{id}', ['uses' => 'Site\World\CityController@fromDB']);
                Route::get('single/{id}', function ($id, \Illuminate\Http\Request $request){
                    $c = new \App\Http\Controllers\Site\World\CityController();
                    return $c->fromDB($id, $request);
                });

                Route::get('{id}', function ($id, \Illuminate\Http\Request $request){
//                    dd($request->all());
                    $c = new \App\Http\Controllers\Painel\World\CityController($id);
                    return $c->display();
                });

                Route::post('{id}', function ($id, \Illuminate\Http\Request $request){
//                    $c = new \App\Http\Controllers\Painel\World\CityController($id);
//
//                    if ( isset($request->createHeadlines) ) {
//                        //return $c->createHeadline($request);
//                        return $c->createOrUpdateHeadline($request);
//                    }
                });
            });

        });

        Route::group(['prefix' => 'interesses'], function (){
            Route::get('', 'Painel\Interests\InterestController@display');
        });

        Route::group(['prefix' => 'paginas'], function (){
            Route::get('home/{id}', function ($id){
                $c = new \App\Http\Controllers\Painel\Pages\HomeController();
                $c->getHome($id);
                return $c->display();
            });
        });

        Route::get('', 'Painel\IndexController@index');
        Route::any('logout', 'Auth\LoginController@logout');

//        Route::get('register', 'Auth\RegisterController@view');
//        Route::post('register', 'Auth\RegisterController@register');

        Route::get('usuarios', 'Painel\system\users\RegisterController@view');
//        Route::post('usuarios/update', 'Painel\system\users\RegisterController@createorupdate');
        Route::post('usuarios', 'Painel\system\users\RegisterController@view');
    });
});