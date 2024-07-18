<?php

use App\Http\Controllers\StegoController;
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

Route::get('/', function () {
    return view('generateKey');
})->name('index');

// Route::get('/', [StegoController::class, 'index'])->name('kalkulator-prima.index');

Route::post('/calculate', [StegoController::class, 'calculate'])->name('generateKey');
Route::get('/reset', [StegoController::class, 'reset'])->name('reset');




Route::get('/encrypt', [StegoController::class, 'encrypt']);
Route::get('/descrypt', [StegoController::class, 'descrypt']);


Route::get('/hide', [StegoController::class, 'showHideForm']);
Route::post('/hide', [StegoController::class, 'hideFile'])->name('hide');
Route::get('/extract', [StegoController::class, 'showExtractForm']);
Route::post('/extract', [StegoController::class, 'extractFile'])->name('extract');

// Route::get('/', [stegoController::class, 'index'])->name('generate.index');
// Route::post('/', [stegoController::class, 'submit'])->name('generate.submit');


