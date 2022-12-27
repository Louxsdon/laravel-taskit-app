<?php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Todo routes
Route::middleware(['auth'])->group(function () {
    Route::get('todos', function () {
        $todos = Todo::all();

        return inertia("Todos/index", ["todos" => $todos]);
    });

    Route::post('todos', function (Request $request) {
        $validated_data = $request->validate([
            'todo'=>'required|min:5',
            'finished'=>'nullable|boolean'
        ]);

        Todo::create($validated_data);

       return redirect("/todos");
    })->name('todos.create');

    // delete todo
    Route::delete('todos/{id}', function ($id) {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect("/todos");
    });
});
