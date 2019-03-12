<?php

Route::view('/', 'welcome');

Route::get('/books', 'BookController@index');

Route::get('/books/{title}', 'BookController@show');
