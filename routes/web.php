<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

//Route::get('/home', 'HomeController@index');

//Socialite facebook integration routes:
Route::get('/login/facebook/redirect', 'SocialAuthController@redirect');
Route::get('/login/facebook/callback', 'SocialAuthController@callback');
Route::get('/logout', 'Auth\LoginController@logout');


//5.2 -> 5.3 routes

//Static pages
Route::get('/', 'PagesController@index');
Route::get('about','PagesController@about');
Route::get('contact','PagesController@contact');
Route::get('faq', 'PagesController@faq');
Route::get('terms', 'PagesController@terms');
Route::post('contact/send', 'PagesController@processContactForm');

//Data export
Route::get('/export/{type}/{id}', 'EventsController@export');

//Events
Route::get('site/admin', 'EventsController@siteAdmin');
Route::get('events/{events}/admin', 'EventsController@admin');
//Route::resource('events','EventsController');
Route::get('events', 'EventsController@index');
Route::get('events/create', 'EventsController@create');
Route::post('events', 'EventsController@store');
Route::get('events/{events}', 'EventsController@show');
Route::get('events/{events}/edit', 'EventsController@edit');
Route::patch('events/{events}', 'EventsController@update');
Route::delete('events/{events}', 'EventsController@destroy');
Route::post('events/{events}/email', 'EventsController@sendMassEmail');

//This is in pagescontroller because of the specific eventrequest that has
//required fields - putting the publish method in pagescontroller gets around this
Route::post('events/{events}/publish', 'PagesController@publish');
Route::post('site/admin/toggleFeatured/{slug}', 'PagesController@siteAdminToggleFeatured');


//This is an event entry form (hence the url) but it's really an Entry method
Route::get('events/{events}/enter', 'EntryController@create');

//Competitions
Route::post('/competition/add', 'CompetitionController@store');
Route::post('/competition/delete/{id}', 'CompetitionController@destroy');
Route::patch('/competition/update/{id}', 'CompetitionController@update');

//Details
Route::post('/detail/add', 'DetailController@store');
Route::post('/detail/delete/{id}', 'DetailController@destroy');

//User pages
Route::get('/user/events', 'PagesController@userEvents');
Route::get('/user/entries', 'PagesController@userEntries');
Route::get('/user/profile', 'PagesController@userProfile');

//Questions
Route::post('/question/add', 'QuestionController@store');
Route::post('/question/delete/{id}', 'QuestionController@destroy');

//Discounts
Route::post('/discount/add', 'DiscountController@store');
Route::post('/discount/delete/{id}', 'DiscountController@destroy');
//Extras
Route::post('/extras/add', 'ExtrasController@store');
Route::post('/extras/delete/{id}', 'ExtrasController@destroy');

//Entries
Route::post('/entry/add', 'EntryController@store');
Route::get('/entry/paid/{event}', 'EntryController@postPaypalComplete');
Route::get('/entry/cancelled/{event}', 'EntryController@postPaypalCancelled');
Route::post('/entry/confirm' , 'EntryController@confirmEntry');
Route::post('/entry/changeDetail/{entry}','EntryController@changeDetail');
Route::post('/entry/cancelCompetition/{entry}', 'EntryController@cancelCompetition');
Route::post('/entry/cancelEntireEntry/{event}', 'EntryController@cancelEntireEntry');
Route::post('/entry/refundedEntry/{entry}', 'EntryController@entryRefunded');

//Route::get('/gatewatest', 'PagesController@home');
//Route::post('/test', 'PagesController@postPaypalSubmit');
Route::get('/payment/{event}', 'PagesController@postPaypalComplete');


