<?php

use App\Http\Controllers\AdminCompanyController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\OffersController;
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

Route::get('/AdminCompany/login', [AdminCompanyController::class, 'login'])->name('AdminCompany.login');
Route::get('/AdminCompany/authenticate', [AdminCompanyController::class, 'authenticate'])->name('AdminCompany.authenticate');
Route::resource('/Clients', ClientsController::class);
Route::resource('/Offers', OffersController::class);
Route::resource('/Categories', CategoriesController::class);
Route::resource('/Companies', CompaniesController::class);
