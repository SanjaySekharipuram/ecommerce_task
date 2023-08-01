<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
    return view('welcome');
});

// Admin Routes
Route::get('admin/register', [AdminController::class, 'showRegistrationForm'])->name('admin.register'); 
Route::post('admin/register', [AdminController::class, 'register'])->name('admin.register.submit');

Route::prefix('admin')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login'])->name('admin.login.submit');

Route::group(['prefix' => 'product'], function () {
    Route::get('/',[ProductController::class,'productIndex'])->name('product.index');
    Route::get('/edit/{id?}', [ProductController::class, 'getProduct'])->name('product.edit');
    Route::get('/get_products',[ProductController::class,'getProducts'])->name('product.get');
    Route::post('/store',[ProductController::class,'store'])->name('product.store');
    Route::delete('/delete/{id?}',[ProductController::class,'delete'])->name('product.delete');
});
});

// User Routes
Route::prefix('user')->group(function () {

    Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('user.register'); 
    Route::post('/register', [UserController::class, 'register'])->name('user.register.submit');
    Route::get('login', [UserController::class, 'showLoginForm'])->name('user.login');
    Route::post('login', [UserController::class, 'login'])->name('user.login.submit');
    Route::get('/', [UserController::class, 'showProductIndex'])->name('user.index');
});

Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class,'showCart'])->name('cart.show');
    Route::post('/add', [CartController::class,'addProduct'])->name('cart.add');
});