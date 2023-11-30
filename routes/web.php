<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Livewire\User\Dashboard;
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
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::prefix("/")->group(function () {
        Route::get('/', Dashboard::class )->name('dashboard');
    });
});

Route::prefix("/admin")->middleware("auth")->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/count', [DashboardController::class, 'get_count'])->name('count');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('/project')->name('project.')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name("index");
        Route::post('/', [ProjectController::class, 'store'])->name("store");
        Route::get('/delete/{uuid}', [ProjectController::class, 'delete_project'])->name("delete");
        Route::get('/edit/{uuid}', [ProjectController::class, 'edit'])->name("edit");
        Route::post('/edit/{uuid}', [ProjectController::class, 'save_edit'])->name("save");
        Route::post('/get_list', [ProjectController::class, 'get_list'])->name("list");
    });

    Route::prefix('/post')->name("post.")->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/edit/{uuid}', [PostController::class, 'edit'])->name('edit');
        Route::post('/edit/{uuid}', [PostController::class, 'save'])->name('save');
        Route::get('/find/{uuid}', [PostController::class, 'find_by_uuid'])->name('find');
        Route::get('/delete/{uuid}', [PostController::class, 'delete'])->name("delete");
    });

    Route::prefix('/category')->name("category.")->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/delete/{uuid}', [CategoryController::class, 'delete_category'])->name("delete");
        Route::get('/edit/{uuid}', [CategoryController::class, 'edit'])->name('edit');
        Route::post('/edit/{uuid}', [CategoryController::class, 'save'])->name('save');
        Route::post('/list', [CategoryController::class, 'list'])->name('list');
    });
});
