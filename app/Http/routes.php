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

	Route::get('/films', [
		'uses' => 'Frontend\HomeController@films',
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

    Route::get('/auth/{provider}', 'Auth\AuthController@redirectToProvider');
	Route::get('/auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

   

	Route::get('/admin/events', [
		'uses' => 'Admin\EventsManagementController@events',
		'as' => 'events',
		'title' => 'Events',
		'subtitle' => '',
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);

	Route::get('/admin/event/add', [
		'uses' => 'Admin\EventsManagementController@addevent',
		'as' => 'events.add',
		'title' => "Events",
		'subtitle' => "Add new event",
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);

	Route::post('/admin/event/add', [
		'uses' => 'Admin\EventsManagementController@postaddevent',
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);

	Route::get('/admin/event/update/{id}', [
		'uses' => 'Admin\EventsManagementController@updateevent',
		'as' => 'events.update',
		'title' => 'Events',
		'subtitle' => 'Update Event',
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);

	Route::patch('/admin/event/update/{id}', [
		'uses' => 'Admin\EventsManagementController@postupdateevent',
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);


	Route::post('/admin/event/delete', [
		'uses' => 'Admin\EventsManagementController@deleteevent',
		'as' => 'events.delete',
		'title' => 'Events',
		'subtitle' => 'Delete Event',
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);
	Route::get('/getsymbolquote/{symbol}', [
		'uses' => 'Admin\EventsManagementController@getsymbolquote',
		'roles' => ['Admin']
	]);


	Route::get('/admin/archive/{eventid}', [
		'uses' => 'Admin\EventsManagementController@alertarchive',
		'as' => 'events.alertarchive',
		'title' => 'Alert Archive',
		'subtitle' => 'List of alerts',
		'middleware' => 'roles',
		'roles' => ['Admin']
	]);



	


// Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//     echo'<pre>';
//     var_dump($query->sql);
//     var_dump($query->bindings);
//     var_dump($query->time);
//     echo'</pre>';
// });
	/* Front End Routes */