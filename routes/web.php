<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'createToken']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::post('/user/store', [UserController::class, 'store']);
Route::patch('/user/{id}/update', [UserController::class, 'update']);
Route::delete('/user/{id}/delete', [UserController::class, 'destroy']);
Route::delete('/user/show/trash/{id}/permanent', [UserController::class, 'destroyPermanent']);
