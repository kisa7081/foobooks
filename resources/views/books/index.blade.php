@extends('layouts.master')

@section('title')
    Your Books
@endsection

@section('content')

    <h1>Recently Added Books</h1>

    <aside>
        @foreach($newBooks as $book)
            <p>{{ $book->title }}</p>
        @endforeach
    </aside>

    <h1>Your Books</h1>

    @foreach($books as $book)
        <p>{{ $book->title }}</p>
    @endforeach

@endsection