<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\FrontController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::resource('/home', HomeController::class);
    Route::resource('magazines', MagazineController::class);
    Route::resource('users', MagazineController::class);
});;

Route::prefix('front')->group(function(){
    Route::get('/', [FrontController::class, 'index']);
    Route::get('/{magazine}/{title}', [FrontController::class, 'show'])->name('front.magazine.show');
});

