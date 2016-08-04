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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => 'auth'], function() {
    Route::get('/admin', 'AdminController@index')->name('admin.user.index');
    Route::get('/admin/users/new', 'AdminController@newUser')->name('admin.user.new');
    Route::post('/admin/users/new', 'AdminController@storeUser')->name('admin.user.store');
    Route::get('/admin/users/edit/{id}', 'AdminController@editUser')->name('admin.user.edit');
    Route::patch('/admin/users/edit/{id}', 'AdminController@updateUser')->name('admin.user.update');

    //
    Route::get('/test', 'AdminController@test');

    // Пользовательская часть
    // Просмотр / создание задач.
    Route::get('/tasks', 'TasksController@index')->name('tasks.index');
    Route::get('/tasks/new', 'TasksController@create')->name('tasks.new');
    Route::post('/tasks/new', 'TasksController@store')->name('tasks.store');
    Route::get('/tasks/edit/{id}', 'TasksController@edit')->name('tasks.edit');
    Route::patch('/tasks/edit/{id}', 'TasksController@update')->name('tasks.update');
    // Список задач: Мои задачи
    Route::get('/tasks/my', 'ListTasksController@myIndex')->name('tasks.my.index');
    // Список задач: Задачи для меня
    Route::get('/tasks/formyself', 'ListTasksController@forMyselfIndex')->name('tasks.formyself.index');


});

Route::get('/logout', ['as' => 'logout', function(){
    \Auth::logout();
    return Redirect::route('home');
}]);

