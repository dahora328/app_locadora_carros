<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::get('/marcas', [MarcaController::class], 'index')->name('marcas')->middleware('auth');
Route::get('/marcas', function (){
    return view('app.marcas');
})->name('marcas')->middleware('auth');
Route::get('/clientes', function (){
    return view('app.clientes');
})->name('clientes')->middleware('auth');
