<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

	// Route::get('/', function () {
	//     return view('welcome');
	// });


	Route::get('/', [
		'uses' => 'Frontend\HomeController@index',
	]);

	Route::get('/films/{offset?}', [
		'uses' => 'Frontend\HomeController@films',
	]);

	Route::get('/film/{slug}', [
		'uses' => 'Frontend\HomeController@filmdetails',
	]);

	Route::get('/films/create', [
		'uses' => 'Frontend\HomeController@createfilm',
	]);

	Route::post('/films/create', [
		'uses' => 'Frontend\HomeController@postcreatefilm',
	]);

	Route::post('/comment/create/{filmid}', [
		'uses' => 'Frontend\HomeController@postfilmcomment',
	]);

	Route::get('/getfilms/{offset?}', [
		'uses' => 'Frontend\HomeController@getfilms',
	]);


	Route::get('/error/404', [
		'uses' => 'Frontend\HomeController@pagenotfound',
	]);

	
	// frontend other routes
	Route::get('/home', [
		'uses' => 'HomeController@index',
		'as' => 'home',
		'middleware' => 'roles',
		'roles' => ['User']
	]);


    /* Admin Routes */
    Route::auth();

	/* Front End Routes */