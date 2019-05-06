@extends('layouts.master')

@section('title')
    Edit a book
@endsection

@section('content')

    <h1>Edit a book</h1>

    <form method='POST' action='/books/{{$book->id}}'>
        <div class='details'>* Required fields</div>
        {{ csrf_field() }}
        {{method_field('PUT')}}

        <label for='title'>* Title</label>
        <input type='text' name='title' id='title' value='{{ old('title') ?? $book->title }}'>
        @include('includes.error-field', ['fieldName' => 'title'])

        <label for='author'>* Author</label>
        <select name='author_id'>
            <option value=''>Choose</option>
            @foreach($authors as $author)
                <option value='{{ $author->id }}' {{ ((old('author_id') ?? $book->author->id) == $author->id) ? 'selected' : '' }}>{{ $author->first_name.' '.$author->last_name }}</option>

            @endforeach

        </select>
        @include('includes.error-field', ['fieldName' => 'author'])

        <label for='published_year'>* Published Year (YYYY)</label>
        <input type='text' name='published_year' id='published_year' value='{{ old('published_year') ?? $book->published_year }}'>
        @include('includes.error-field', ['fieldName' => 'published_year'])

        <label for='cover_url'>* Cover URL</label>
        <input type='text' name='cover_url' id='cover_url' value='{{ old('cover_url') ?? $book->cover_url }}'>
        @include('includes.error-field', ['fieldName' => 'cover_url'])

        <label for='purchase_url'>* Purchase URL </label>
        <input type='text' name='purchase_url' id='purchase_url' value='{{ old('purchase_url') ?? $book->cover_url }}'>
        @include('includes.error-field', ['fieldName' => 'purchase_url'])

        <label>Tags</label>
        @foreach($tags as $tag)
            <ul>
                <li>
                    <label>
                        <input {{ (in_array($tag->id, $bookTags)) ? 'checked' : '' }} type='checkbox' name='tags[]' value='{{ $tag->id }}'>{{ $tag->name }}
                    </label>
                </li>
            </ul>
        @endforeach

        <input type='submit' value='Save Changes'>
    </form>
    @if(count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection