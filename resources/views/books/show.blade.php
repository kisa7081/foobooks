@extends('layouts.master')

@section('title')
    {{ $book->title }}
@endsection

@section('head')
    {{-- Page specific CSS includes should be defined here; this .css file does not exist yet, but we can create it --}}
    <link href='/css/books/show.css' rel='stylesheet'>
@endsection

@section('content')


    <h1>{{ $book->title }}</h1>

    <p>
        @include('books._book')
    </p>

    <a href='/books/{{ $book->id }}/edit'><i class="fas fa-delete">Edit</i>
    <form method='POST' action='/books/delete/{{$book->id}}'>
        {{ csrf_field() }}
        @method('DELETE')
        <input type='submit' value='Delete Book'>
    </form>
@endsection