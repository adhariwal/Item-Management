<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
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

//Route::get('/', function () {
  //  return view('welcome');
///});


Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::post('/add', [WelcomeController::class, 'AddItem'])->name('AddItem');
Route::post('/RightToLeft', [WelcomeController::class, 'RightToLeft'])->name('RightToLeft');
Route::post('/LeftToRight', [WelcomeController::class, 'LeftToRight'])->name('LeftToRight');

Route::get('/GetData', [WelcomeController::class, 'GetData'])->name('GetData');