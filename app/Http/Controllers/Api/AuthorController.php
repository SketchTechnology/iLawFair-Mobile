<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use Illuminate\Http\Request;


class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        $authorsResource = AuthorResource::collection($authors);
        return ApiResponse::sendResponse(200, 'Authors retrieved successfully', $authorsResource);
    }

    public function booksByAuthor(Author $author)
    {
        $books = $author->books;
        $booksResource = BookResource::collection($books);
        return ApiResponse::sendResponse(200, 'Books retrieved successfully for the specified author', $booksResource);
    }


    public function search(Request $request)
    {
        $query = $request->get('query');

        $authors = Author::where('name', 'like', "%$query%")
                    ->get();

        $authorsResource = AuthorResource::collection($authors);

        return ApiResponse::sendResponse(200, 'Authors retrieved successfully', $authorsResource);
    }

    
}
