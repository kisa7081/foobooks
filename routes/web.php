<?php

Route::view('/', 'welcome');

Route::get('/books/search', 'BookController@search');
Route::get('/books/search-process', 'BookController@searchProcess');

Route::get('/books', 'BookController@index');


Route::get('/books/create', 'BookController@create');
Route::post('/books', 'BookController@store');

Route::get('/books/{title}', 'BookController@show');


Route::any('/practice/{n?}', 'PracticeController@index');

