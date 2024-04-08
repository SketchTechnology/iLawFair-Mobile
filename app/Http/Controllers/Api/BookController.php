<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\PublishingHouse;



class BookController extends Controller
{


   public function index()
{
    $books = Book::all();
    $booksResource = BookResource::collection($books);
    return ApiResponse::sendResponse(200, 'Books retrieved successfully', $booksResource);
}


public function booksByCategory(Category $category)
{
    $books = $category->books;
    $booksResource = BookResource::collection($books);
    return ApiResponse::sendResponse(200, 'Books retrieved successfully for the specified category', $booksResource);
}



public function booksByPublishingHouse(PublishingHouse $publishingHouse)
{
    $books = $publishingHouse->books;
    $booksResource = BookResource::collection($books);
    return ApiResponse::sendResponse(200, 'Books retrieved successfully for the specified publishing house', $booksResource);
}




public function download($id)
{
    $book = Book::findOrFail($id);
    $filePath = public_path("books/{$book->file_path}");

    return response()->download($filePath, "{$book->title}.pdf");
}



public function search(Request $request)
{
    $query = $request->get('query');

    $books = Book::where('title', 'like', "%$query%")
                ->get();

     $booksResource = BookResource::collection($books);

    return ApiResponse::sendResponse(200, 'Books retrieved successfully', $booksResource);
}

}
