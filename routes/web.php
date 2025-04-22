<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/library/logout', [HomeController::class, 'logout'])->name('login.logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/library/bookstore', [BooksController::class, 'index'])->name('bookstore');
    Route::post('/library/bookstore', [BooksController::class, 'CreateBooks']);
    Route::get('/library/bookstore/edit', [BooksController::class, 'getID']);
    Route::post('/library/bookstore/getdata', [BooksController::class, 'Data']);
    Route::post('/library/bookstore/put/{id}', [BooksController::class, 'UpdateBooks']);
    Route::delete('/library/bookstore', [BooksController::class, 'Deletebookstore']);
    Route::get('/library/bookstore/search', [BooksController::class, 'SearchBooks']);
    Route::get('/library/bookstore/export', [BooksController::class, 'export']);
    Route::post('/library/bookstore/send-export', [BooksController::class, 'sendExportByEmail']);

    Route::get('/library/authors', [AuthorsController::class, 'index'])->name('authors');
    Route::post('/library/authors', [AuthorsController::class, 'CreateAuthors']);
    Route::get('/library/authors/edit', [AuthorsController::class, 'getID']);
    Route::post('/library/authors/getdata', [AuthorsController::class, 'Data']);
    Route::post('/library/authors/put/{id}', [AuthorsController::class, 'UpdateAuthors']);
    Route::delete('/library/authors', [AuthorsController::class, 'DeleteAuthors']);
    Route::get('/library/authors/search', [AuthorsController::class, 'SearchAuthors']);
    Route::get('/library/authors/export', [AuthorsController::class, 'export']);
    Route::post('/library/authors/send-export', [AuthorsController::class, 'sendExportByEmail']);

    Route::get('/library/publisher', [PublisherController::class, 'index'])->name('publisher');
    Route::post('/library/publisher/', [PublisherController::class, 'CreatePublisher']);
    Route::get('/library/publisher/edit', [PublisherController::class, 'getID']);
    Route::post('/library/publisher/getdata', [PublisherController::class, 'Data']);
    Route::post('/library/publisher/put/{id}', [PublisherController::class, 'UpdatePublisher']);
    Route::delete('/library/publisher', [PublisherController::class, 'DeletePublisher']);
    Route::get('/library/publisher/search', [PublisherController::class, 'SearchPublisher']);
    Route::get('/library/publisher/export', [PublisherController::class, 'export']);
    Route::post('/library/publisher/send-export', [PublisherController::class, 'sendExportByEmail']);


});



