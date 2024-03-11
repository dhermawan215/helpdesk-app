<?php

use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\UserGroupController;
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
    return view('welcome');
});

Route::get('/home', function () {
    $title = 'Dashboard';
    return view('dashboard', ['title' => $title]);
})->middleware('auth');
// admin route
Route::prefix('admin')->middleware('auth')->group(function () {
    // route User Group
    Route::get('/user-group', [UserGroupController::class, 'index'])->name('user_group');
    Route::post('/user-group/list', [UserGroupController::class, 'list']);
    Route::post('/user-group/save', [UserGroupController::class, 'store']);
    Route::patch('/user-group/update/{id}', [UserGroupController::class, 'update']);
    Route::post('/user-group/delete', [UserGroupController::class, 'delete']);
});
