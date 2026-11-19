<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\LoginController;
use App\Models\Recipe;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/recipes/create', [RecipeController::class, 'create'])->name('recipes.create')->middleware('auth')->can('create', Recipe::class);
Route::post('/recipes', [RecipeController::class, 'store'])->name('recipes.store')->middleware('auth')->can('create', Recipe::class);

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index')->can('viewAny', Recipe::class);
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show')->can('view', 'recipe');

Route::get('/recipes/{recipe}/edit', [RecipeController::class, 'edit'])->name('recipes.edit')->middleware('auth')->can('update', 'recipe');
Route::put('/recipes/{recipe}', [RecipeController::class, 'update'])->name('recipes.update')->middleware('auth')->can('update', 'recipe');
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy'])->name('recipes.destroy')->middleware('auth')->can('delete', 'recipe');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register.create');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');