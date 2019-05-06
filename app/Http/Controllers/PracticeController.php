<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use IanLChapman\PigLatinTranslator\Parser;
use App\Book;
use App\Author;

class PracticeController extends Controller
{
    public function practice13()
    {
        $book = Book::first();

        dump($book->tags);
        dump($book->tags());
    }

    public function practice12()
    {
        $books = Book::with('tags')->get();

        foreach ($books as $book) {
            dump($book->title);
            foreach ($book->tags as $tag) {
                dump($tag->name);
            }
        }
    }

    public function practice11()
    {
        $books= Book::all();

        foreach($books as $book) {
            dump($book->author->first_name.' '.$book->author->last_name.' wrote '.$book->title);
        }
    }


    public function practice10()
    {
        $book = Book::first();

        $author = $book->author;
    }
    public function practice9()
    {
        $author = Author::where('first_name', '=', 'J.K.')->first();

        $book = new Book();
        $book->title = "Fantastic Beasts and Where to Find Them";
        $book->published_year = 2017;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9781338132311_p0_v2_s192x300.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/fantastic-beasts-and-where-to-find-them-j-k-rowling/1004478855';
        $book->author()->associate($author); # <--- Associate the author with this book
        $book->save();
        dump($book->toArray());
    }


    public function practice8()
    {
        $book = Book::where('id', '=', '777')->get();
        $book->delete();
        dump('Book deleted.');
        # First get a book to delete
        $book = Book::where('id', '=', '444')->first();
        $book->delete();
        if (!$book) {
            dump('Did not delete- Book not found.');
        } else {
            $book->delete();
            dump('Deletion complete; check the database to see if it worked...');
        }
    }
    public function practice7()
    {
        # First get a book to update
        $book = Book::where('author', '=', 'F. Scott Fitzgerald')->first();

        if (!$book) {
            dump("Book not found, can't update.");
        } else {
            # Change some properties
            $book->title = 'The Really Great Gatsby';
            $book->published_year = '2025';

            # Save the changes
            $book->save();

            dump('Update complete; check the database to confirm the update worked.');
        }
    }
    public function practice6()
    {
//        $book = new Book();
        $results = Book::where('author', 'like', '%Rowling%')->delete();

        if ($results->isEmpty()) {
            dump('No matches found');
        } else {
            foreach ($results as $book) {
                dump($book->title);
            }
        }
    }


    public function practice5()
    {
        # Instantiate a new Book Model object
        $book = new Book();

        # Set the properties
        # Note how each property corresponds to a field in the table
        $book->title = 'Harry Potter and the Sorcerer\'s Stone';
        $book->author = 'J.K. Rowling';
        $book->published_year = 1997;
        $book->cover_url = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_url = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';

        # Invoke the Eloquent `save` method to generate a new row in the
        # `books` table, with the above data
        $book->save();

        dump($book->toArray());
    }
    /**
     *
     */
    public function practice3()
    {
        $translator = new Parser();
        $translation = $translator->translate('Hello World');
        dump($translation);
    }
    /**
     *
     */
    public function practice2()
    {
        return 'Need help? Email us at '.config('mail.supportEmail');
    }
    /**
     * Demonstrating the first practice example
     */
    public function practice1()
    {
        dump('This is the first example.');
    }
    /**
     * ANY (GET/POST/PUT/DELETE)
     * /practice/{n?}
     * This method accepts all requests to /practice/ and
     * invokes the appropriate method.
     * http://foobooks.loc/practice => Shows a listing of all practice routes
     * http://foobooks.loc/practice/1 => Invokes practice1
     * http://foobooks.loc/practice/5 => Invokes practice5
     * http://foobooks.loc/practice/999 => 404 not found
     */
    public function index($n = null)
    {
        $methods = [];
        # Load the requested `practiceN` method
        if (!is_null($n)) {
            $method = 'practice' . $n; # practice1
            # Invoke the requested method if it exists; if not, throw a 404 error
            return (method_exists($this, $method)) ? $this->$method() : abort(404);
        } # If no `n` is specified, show index of all available methods
        else {
            # Build an array of all methods in this class that start with `practice`
            foreach (get_class_methods($this) as $method) {
                if (strstr($method, 'practice')) {
                    $methods[] = $method;
                }
            }
            # Load the view and pass it the array of methods
            return view('practice')->with(['methods' => $methods]);
        }
    }
}