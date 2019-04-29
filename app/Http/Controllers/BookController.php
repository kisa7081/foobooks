<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('title')->get();

        $newBooks = $books->sortByDesc('vrerated_at')->take(3);

        return view('books.index')->with([
            'books' => $books,
            'newBooks' => $newBooks
        ]);
    }

    public function show($id)
    {
        $book = Book::find($id);
        if(!$book) {
            return redirect('/books')->with(['alert' => 'The book you were looking for was not found.']);
        }
        return view('books.show')->with([
            'book'=> $book
        ]);
    }

    public function searchProcess(Request $request) {



        # ======== End exploration of $request ==========

        # Start with an empty array of search results; books that
        # match our search query will get added to this array
        $request->validate([
            'searchTerm' => 'required'
        ]);

        $searchResults = [];

        # Store the searchTerm in a variable for easy access
        # The second parameter (null) is what the variable
        # will be set to *if* searchTerm is not in the request.
        $searchTerm = $request->input('searchTerm', null);

        # Only try and search *if* there's a searchTerm
        if ($searchTerm) {
            # Open the books.json data file
            # database_path() is a Laravel helper to get the path to the database folder
            # See https://laravel.com/docs/helpers for other path related helpers
            $booksRawData = file_get_contents(database_path('/books.json'));

            # Decode the book JSON data into an array
            # Nothing fancy here; just a built in PHP method

            $searchResults;
            if ($request->has('caseSensitive')) {
                $searchResults = Book::where('title', 'like', '\'%'.$searchTerm.'%\'')->get();
            }
            else {
                $searchResults = Book::whereRaw('lower(title) like \'%'.strtolower($searchTerm).'%\'')->get();
            }

            # Loop through all the book data, looking for matches
            # This code was taken from v0 of foobooks we built earlier in the semester
//            foreach ($books as $title => $book) {
//                # Case sensitive boolean check for a match
//                if ($request->has('caseSensitive')) {
//                    $match = $title == $searchTerm;
//                    # Case insensitive boolean check for a match
//                } else {
//                    $match = strtolower($title) == strtolower($searchTerm);
//                }
//
//                # If it was a match, add it to our results
//                if ($match) {
//                    $searchResults[$title] = $book;
//                }
//            }
        }

        # Redirect back to the search page w/ the searchTerm *and* searchResults (if any) stored in the session
        # Ref: https://laravel.com/docs/redirects#redirecting-with-flashed-session-data
        return redirect('/books/search')->with([
            'searchTerm' => $searchTerm,
            'caseSensitive' => $request->has('caseSensitive'),
            'searchResults' => $searchResults
        ]);
    }

    public function search(Request $request)
    {
        return view('books.search')->with([
            'searchTerm' => $request->session()->get('searchTerm', ''),
            'caseSensitive' => $request->session()->get('caseSensitive', false),
            'searchResults' => $request->session()->get('searchResults', []),
        ]);
    }

    /**
     * GET /books/create
     * Display the form to add a new book
     */
    public function create(Request $request)
    {
        return view('books.create');
    }


    /**
     * POST /books
     * Process the form for adding a new book
     */
    public function store(Request $request)
    {
        # Validate the request data
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|digits:4',
            'cover_url' => 'required|url',
            'purchase_url' => 'required|url'
        ]);

        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_year = $request->published_year;
        $book->cover_url = $request->cover_url;
        $book->purchase_url = $request->purchase_url;


        # Note: If validation fails, it will redirect the visitor back to the form page
        # and none of the code that follows will execute.

        $book->save();
        return redirect('/books/create')->with(['alert' => 'The book ' . $book->title . ' was added.']);;
    }

    public function edit($id)
    {
        $book = Book::find($id);
        if(!$book) {
            return redirect('/books')->with(['alert' => 'The book you were looking for was not found.']);
        }
        return view('books.edit')->with([
            'book'=> $book
        ]);
    }

    public function update(Request $request, $id)
    {
        # Validate the request data
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'published_year' => 'required|digits:4',
            'cover_url' => 'required|url',
            'purchase_url' => 'required|url'
        ]);

        $book = Book::find($id);
        if(!$book) {
            return redirect('/books')->with(['alert' => 'The book you were looking for was not found.']);
        }
        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = $request->title;
        $book->author = $request->author;
        $book->published_year = $request->published_year;
        $book->cover_url = $request->cover_url;
        $book->purchase_url = $request->purchase_url;


        # Note: If validation fails, it will redirect the visitor back to the form page
        # and none of the code that follows will execute.

        $book->save();
        return redirect('/books/'.$id.'/edit')->with(['alert' => 'The book ' . $book->title . ' was updated.']);
    }

    public function delete($id)
    {
        $book = Book::find($id);
        if(!$book) {
            return redirect('/books')->with(['alert' => 'The book you were looking for was not found.']);
        }
        $book->delete();
        return redirect('/books')->with(['alert' => 'The book ' . $book->title . ' was deleted.']);
    }
}

