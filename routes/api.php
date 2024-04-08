<?php

use App\Http\Controllers\Api\Authentication\ChangePasswordController;
use App\Http\Controllers\Api\Authentication\UpdateProfileController;
use App\Http\Controllers\Api\Authentication\UserLogin;
use App\Http\Controllers\Api\Authentication\UserRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\PublishingHouseController as ApiPublishingHouseController;

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

// Auth 
Route::post('user-register', [UserRegister::class, 'register']);

Route::post('user-login', [UserLogin::class, 'login']);

Route::post('password/change', [ChangePasswordController::class, 'changePassword']);

Route::put('user/update', [UpdateProfileController::class, 'update']);

// -------------------------------------------------------------------

Route::get('main-categories', [CategoryController::class, 'mainCategories']);
Route::get('sub-categories/{category}', [CategoryController::class, 'subCategories']);
Route::get('books', [BookController::class, 'index']);
Route::get('books/category/{category}', [BookController::class, 'booksByCategory']);
Route::get('books/publishing-house/{publishingHouse}', [BookController::class, 'booksByPublishingHouse']);
Route::get('authors', [AuthorController::class, 'index']);
Route::get('authors/search', [AuthorController::class, 'search']);
Route::get('authors/{author}/books', [AuthorController::class, 'booksByAuthor']);
Route::get('publishing-houses', [ApiPublishingHouseController::class, 'index']);
Route::get('publishing-houses/search', [ApiPublishingHouseController::class, 'search']);

Route::get('books/search', [BookController::class, 'search']);

Route::get('/books/{id}', [BookController::class, 'download']);
