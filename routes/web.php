<?php

Route::view('/', 'welcome');

Route::get('/books/search', 'BookController@search');
Route::get('/books/search-process', 'BookController@searchProcess');

Route::get('/books', 'BookController@index');


Route::get('/books/create', 'BookController@create');
Route::post('/books', 'BookController@store');

Route::get('/books/{id}', 'BookController@show');


Route::any('/practice/{n?}', 'PracticeController@index');

# Show the form to edit a specific book
Route::get('/books/{id}/edit', 'BookController@edit');

# Process the form to edit a specific book
Route::put('/books/{id}', 'BookController@update');

Route::delete('books/delete/{id}', 'BookController@delete');

Route::get('/debug', function () {

    $debug = [
        'Environment' => App::environment(),
    ];

    /*
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    */
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});