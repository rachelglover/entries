<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

//TEST CODE FOR PAYMENT GATEWAY



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
    Route::get('/', 'HomeController@index');

    //Static pages
    Route::get('about','PagesController@about');
    Route::get('contact','PagesController@contact');
    Route::get('faq', 'PagesController@faq');
    Route::get('terms', 'PagesController@terms');

    //Events
    Route::get('events/{events}/admin', 'EventsController@admin');
    Route::get('events/{events}/admin/competitors', 'EventsController@adminCompetitors');
    Route::get('events/{events}/admin/finance', 'EventsController@adminFinance');
    Route::get('events/{events}/admin/entries', 'EventsController@adminEntries');
    Route::get('events/{events}/admin/extras', 'EventsController@adminExtras');
    Route::resource('events','EventsController');
    //This is in pagescontroller because of the specific eventrequest that has
    //required fields - putting the publish method in pagescontroller gets around this
    Route::post('events/{events}/publish', 'PagesController@publish');
    Route::get('/events/{events}/export/competitors', 'EventsController@exportCompetitors');

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
    Route::post('/entry/paid/{event}', 'EntryController@postPaypalComplete');
    Route::post('/entry/cancelled/{event}', 'EntryController@postPaypalCancelled');
    Route::post('/entry/confirm' , 'EntryController@confirmEntry');

    //Route::get('/gatewatest', 'PagesController@home');
    //Route::post('/test', 'PagesController@postPaypalSubmit');
    Route::get('/payment/{event}', 'PagesController@postPaypalComplete');
});
