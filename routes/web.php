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
    Route::get('todos', [TodoController::class, 'index']);

    Route::post('todos', [TodoController::class, 'create'])->name('todos.create');

    // delete todo
    Route::delete('todos/{id}', function ($id) {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect("/todos");
    });

    Route::put('todos/{id}', function (Request $request, $id) {
        $todo = Todo::findOrFail($id);

        $validated = $request->validate([
            'todo'=>'required|min:5',
            'finished'=>'nullable|boolean'
        ]);
        
        $todo->update($validated);

        return redirect("/todos");
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
