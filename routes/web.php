<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use App\Models\Todo;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Todo routes
Route::middleware(['auth'])->group(function () {
    // retrieve all todos
    Route::get('todos', [TodoController::class, 'index']);

    // create new todo
    Route::post('todos', [TodoController::class, 'create'])->name('todos.create');

    // delete todo
    Route::delete('todos/{id}', [TodoController::class, 'destroy']);

    // update todo
    Route::put('todos/{id}', [TodoController::class, 'update']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
