<?php

use App\Http\Controllers\UserController;
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
    Route::get('/my-account', [HomeController::class, 'my_account'])->name('my-account.index');
    Route::resource('magazines', MagazineController::class);
    Route::resource('users', UserController::class)->middleware('can:is_admin');
    Route::get('users/delete/{id}', [UserController::class, 'delete'])->middleware('can:is_admin')->name('users.delete');
    Route::post('magazine/purchase', [MagazineController::class, 'purchase'])->name('magazine.purchase');
    Route::get('/billing-portal', [HomeController::class, 'billing_portal'])->name('billing.portal');
});;

Route::prefix('front')->group(function(){
    Route::get('/', [FrontController::class, 'index'])->name('front.index');
    Route::get('/{magazine}/{title}', [FrontController::class, 'show'])->middleware('auth')->name('front.magazine.show');
});

