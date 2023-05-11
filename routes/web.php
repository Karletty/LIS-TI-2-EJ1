<?php

use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Middleware\AuthCheck;
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

session_start();
Route::get('/', function () {
      return view('welcome');
});

Route::get('login', [AdminCompanyController::class, 'login'])->name('login');
Route::get('authenticate', [AdminCompanyController::class, 'authenticate'])->name('authenticate');
Route::get('changePassword', [AdminCompanyController::class, 'logout'])->name('changePassword');
Route::get('logout', [AdminCompanyController::class, 'logout'])->name('logout');
Route::get('/Client/signup', [AdminCompanyController::class, 'signup'])->name('Client.signup');
Route::post('/ShoppingCart/add/{id}', [ShoppingCartController::class, 'add'])->name('ShoppingCart.add')->middleware(AuthCheck::class);
Route::post('/ShoppingCart/validatePay', [ShoppingCartController::class, 'validatePay'])->name('ShoppingCart.validatePay')->middleware(AuthCheck::class);
Route::post('/ShoppingCart/remove/{id}', [ShoppingCartController::class, 'remove'])->name('ShoppingCart.remove')->middleware(AuthCheck::class);
Route::get('/Coupons/createCoupons', [CouponsController::class, 'createCoupons'])->name('Coupons.createCoupons')->middleware(AuthCheck::class);
Route::get('/ShoppingCart', [ShoppingCartController::class, 'index'])->name('ShoppingCart.index')->middleware(AuthCheck::class);
Route::get('/Coupons', [CouponsController::class, 'index'])->name('Coupons.index')->middleware(AuthCheck::class);
Route::resource('/Clients', ClientsController::class)->middleware(AuthCheck::class);
Route::resource('/Offers', OffersController::class)->middleware(AuthCheck::class);
Route::resource('/Categories', CategoriesController::class)->middleware(AuthCheck::class);
Route::resource('/Companies', CompaniesController::class)->middleware(AuthCheck::class);
