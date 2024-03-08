<?php

use App\Http\Controllers\AuthenticatedController;
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

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedController::class, 'login'])->name('login');
    Route::post('login', [AuthenticatedController::class, 'authenticated']);
});
Route::get('/', function () {
    $title = 'Dashboard';
    return view('dashboard', ['title' => $title]);
})->middleware('auth');
// admin route
Route::prefix('admin')->middleware('auth')->group(function () {
});
