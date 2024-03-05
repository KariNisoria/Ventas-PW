<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[homeController::class,'index'])->name('panel')->middleware('auth');

Route::resources([
    'categorias'=>categoriaController::class,
    'productos'=> ProductoController::class,
    'ventas'=>VentaController::class,
    'profiles'=> profileController::class
]);

Route::get('/login', [loginController::class,'index'])->name('login');

Route::post('/login',[loginController::class,'login']);

Route::get('/logout',[logoutController::class,'logout'])->name('logout');

Route::get('/404', function () {
    return view('pages.404');
});

Route::get('/401', function () {
    return view('pages.401');
});

Route::get('/500', function () {
    return view('pages.500');
});
