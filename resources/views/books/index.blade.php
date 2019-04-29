@extends('layouts.master')

@section('title')
    Your Books
@endsection

@section('content')

    <h1>Recently Added Books</h1>

    <section>
        @foreach($newBooks as $book)
            @include('books._book')
        @endforeach
    </section>

    <h1>Your Books</h1>

    @foreach($books as $book)
        @include('books._book')
    @endforeach

@endsection