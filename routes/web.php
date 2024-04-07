<?php

use App\Http\Controllers\AuthenticatedController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserManagementController;
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
    Route::get('/login', [AuthenticatedController::class, 'login'])->name('login');
    Route::post('/login', [AuthenticatedController::class, 'authenticated']);
});
Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $title = 'Dashboard';
        return view('dashboard', ['title' => $title]);
    })->middleware('auth');

    // route logout
    Route::post('/logout', [AuthenticatedController::class, 'logout']);
});
// admin route
Route::prefix('admin')->middleware('auth')->group(function () {
    // Route User Group
    Route::get('/user-group', [UserGroupController::class, 'index'])->name('user_group');
    Route::post('/user-group/list', [UserGroupController::class, 'list']);
    Route::post('/user-group/list-user-group', [UserGroupController::class, 'listUserGroup']);
    Route::post('/user-group/save', [UserGroupController::class, 'store']);
    Route::patch('/user-group/update/{id}', [UserGroupController::class, 'update']);
    Route::post('/user-group/delete', [UserGroupController::class, 'delete']);
    // Route user management
    Route::get('/user-management', [UserManagementController::class, 'index'])->name('user_management');
    Route::post('/user-management/list', [UserManagementController::class, 'list']);
    Route::get('/user-management/add', [UserManagementController::class, 'add'])->name('user_management.add');
    Route::post('/user-management/register', [UserManagementController::class, 'registerUser']);
    Route::post('/user-management/active-user', [UserManagementController::class, 'activeUser']);
});
