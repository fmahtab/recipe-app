<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create');
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store');

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit');
Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update');
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register.create');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

