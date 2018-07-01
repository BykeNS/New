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

/*Route::get('/', function () {
    return view('home');

});

Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');
   
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/
 
Route::get('/', function () {
    return view('shared.navbar');
});


Route::get('/contact', 'TicketsController@create');
Route::post('/contact', 'TicketsController@store');
Route::get('/tickets', 'TicketsController@index');
Route::get('/ticket/{slug}', 'TicketsController@show');
Route::get('/ticket/{slug}/edit','TicketsController@edit');
Route::post('/ticket/{slug}/edit','TicketsController@update');
Route::post('/ticket/{slug}/delete','TicketsController@destroy');
//Route::resource('/tickets', 'TicketsController');
Route::post('/comment', 'CommentsController@newComment');

Route::get('sendemail', function () {
$data = array(
'name' => "Learning Laravel 5.5",
);
Mail::send('emails.welcome', $data, function ($message) {
$message->from('vladimirbajic5@gmail.com', 'Learning Laravel 5.5');
$message->to('vladimirbajic5@gmail.com')->subject(' Test email');

});
return "Your email has been sent successfully";
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
