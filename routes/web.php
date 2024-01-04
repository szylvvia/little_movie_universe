<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/artists', [App\Http\Controllers\ArtistController::class, 'showArtists'])->name('showArtists');
Route::get('/movies', [App\Http\Controllers\MovieController::class, 'showMovies'])->name('showMovies');
Route::get('/movies/{id}', [App\Http\Controllers\MovieController::class, 'showMovie'])->name('showMovie');
Route::get('/artists/{id}', [App\Http\Controllers\ArtistController::class, 'showArtist'])->name('showArtist');

Route::get('/search/{string}', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
Route::get('/searchReturnJson/{string}', [App\Http\Controllers\SearchController::class, 'searchReturnJson'])->name('searchReturnJson');
Route::get('/showUser/{id}', [App\Http\Controllers\UserController::class, 'showUser'])->name('showUser');


Auth::routes();
Route::get('/addArtist', [App\Http\Controllers\ArtistController::class, 'addArtistForm'])->name('addArtistForm');
Route::post('/addArtist', [App\Http\Controllers\ArtistController::class, 'addArtist'])->name('addArtist');
Route::get('/editArtist/{id}', [App\Http\Controllers\ArtistController::class, 'editArtistForm'])->name('editArtistForm');
Route::post('/editArtist/{id}', [App\Http\Controllers\ArtistController::class, 'editArtist'])->name('editArtist');

Route::get('/addMovie', [App\Http\Controllers\MovieController::class, 'addMovieForm'])->name('addMovieForm');
Route::post('/addMovie', [App\Http\Controllers\MovieController::class, 'addMovie'])->name('addMovie');
Route::delete("movies/{id}", [App\Http\Controllers\MovieController::class, 'deleteMovie'])->name('deleteMovie');
Route::delete("artists/{id}", [App\Http\Controllers\ArtistController::class, 'deleteArtist'])->name('deleteArtist');
Route::get('/movies/edit/{id}', [App\Http\Controllers\MovieController::class, 'editMovieForm'])->name('editMovieForm');
Route::post('/movies/edit/{id}', [App\Http\Controllers\MovieController::class, 'editMovie'])->name('editMovie');
Route::post("movies/{id}", [App\Http\Controllers\RateController::class, 'addOrEditRate'])->name('addOrEditRate');
Route::delete("movies/rate/{id}", [App\Http\Controllers\RateController::class, 'deleteRate'])->name('deleteRate');
Route::delete("/profile", [App\Http\Controllers\UserController::class, 'deleteUser'])->name('deleteUser');
Route::get('/editProfile', [App\Http\Controllers\UserController::class, 'editUserForm'])->name('editUserForm');
Route::post('/editProfile', [App\Http\Controllers\UserController::class, 'editUser'])->name('editUser');
Route::post('/addToCollection',[App\Http\Controllers\MovieController::class, 'addToCollection'])->name('addToCollection');
Route::post('/deleteFromCollection',[App\Http\Controllers\MovieController::class, 'deleteFromCollection'])->name('deleteFromCollection');


Route::get('/adminPanel', [App\Http\Controllers\AdminController::class, 'showAdminPanel'])->name('showAdminPanel');
Route::post('/verifyMovie', [App\Http\Controllers\AdminController::class, 'verifyMovie'])->name('verifyMovie');
Route::post('/verifyArtist', [App\Http\Controllers\AdminController::class, 'verifyArtist'])->name('verifyArtist');

Route::get('/addQuiz', [App\Http\Controllers\QuizController::class, 'addQuizForm'])->name('addQuizForm');
Route::post('/addQuiz', [App\Http\Controllers\QuizController::class, 'addQuiz'])->name('addQuiz');
Route::post('/addAnswer', [App\Http\Controllers\QuizController::class, 'addAnswer'])->name('addAnswer');
Route::post('/deleteAnswer', [App\Http\Controllers\QuizController::class, 'deleteAnswer'])->name('deleteAnswer');

Route::delete("/deleteQuiz/{id}", [App\Http\Controllers\QuizController::class, 'deleteQuiz'])->name('deleteQuiz');
Route::get('/editQuiz/{id}', [App\Http\Controllers\QuizController::class, 'editQuizForm'])->name('editQuizForm');
Route::post('/editQuiz/{id}', [App\Http\Controllers\QuizController::class, 'editQuiz'])->name('editQuiz');




