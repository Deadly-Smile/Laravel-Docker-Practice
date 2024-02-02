<?php

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/books', function (Request $request) {
    // return response()->json($request['id']);
    $book = Book::Create([
        'bookId' => (int)$request['id'],
        'title' => $request['title'],
        'author' => $request['author'],
        'genre' => $request['genre'],
        'price' => $request['price'],
    ]);
    $sendingData = [
        'id' => $book->bookId,
        'title' => $book->title,
        'author' => $book->author,
        'genre' => $book->genre,
        'price' => (float)$book->price,
    ];
    return response()->json($sendingData, 201);
});

Route::put('/books/{id}', function (Request $request, $id) {
    $book = Book::where('bookId', $id)->first();
    if (!$book) {
        return response()->json(['message' => 'book with id: ' . $id . ' was not found'], 404);
    }

    // return response()->json($request);
    $book->title = $request['title'];
    $book->author = $request['author'];
    $book->genre = $request['genre'];
    $book->price = $request['price'];
    $book->save();

    $sendingData = [
        'id' => $book->bookId,
        'title' => $book->title,
        'author' => $book->author,
        'genre' => $book->genre,
        'price' => (float)$book->price,
    ];
    return response()->json($sendingData, 200);
});

Route::get('/books/{id}', function ($id) {
    $book = Book::where('bookId', $id)->first();
    if (!$book) {
        return response()->json(['message' => 'book with id: ' . $id . ' was not found'], 404);
    }
    $sendingData = [
        'id' => $book->bookId,
        'title' => $book->title,
        'author' => $book->author,
        'genre' => $book->genre,
        'price' => (float)$book->price,
    ];
    return response()->json($sendingData, 200);
});

Route::get('/books', function (Request $request) {
    $title = $request->input('title');
    $author = $request->input('author');
    $genre = $request->input('genre');
    $sortField = $request->input('sort');
    $sortingOrder = $request->input('order');

    $booksQuery = Book::query();

    if ($title) {
        $booksQuery->where('title', 'like', '%' . $title . '%');
    }

    if ($author) {
        $booksQuery->where('author', 'like', '%' . $author . '%');
    }

    if ($genre) {
        $booksQuery->where('genre', 'like', '%' . $genre . '%');
    }

    if ($sortField) {
        $booksQuery->orderBy($sortField, $sortingOrder ?? 'asc');
    } else {
        $booksQuery->orderBy('bookId', $sortingOrder ?? 'asc');
    }

    $books = $booksQuery->get();
    $sendingData = array();
    foreach ($books as $book) {
        $temp = [
            'id' => $book->bookId,
            'title' => $book->title,
            'author' => $book->author,
            'genre' => $book->genre,
            'price' => (float)$book->price,
        ];
        array_push($sendingData, $temp);
    }
    // if (!$book) {
    //     return response()->json(['message' => 'book with id: ' . $id . ' was not found'], 404);
    // }
    return response()->json(['books' => $sendingData], 200);
});
