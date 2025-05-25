<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Volt::route('recipes/public/{recipe}', ' recipes.show')
    ->name(' ');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Volt::route('recipes', 'recipes.myRecipes')
        ->name('recipes.index');

    Volt::route('recipes/create', 'recipes.create')
        ->name('recipes.create');

    Volt::route('recipes/{recipe}', 'recipes.show')
        ->name('recipes.show');

    Volt::route('recipes/{recipes}/edit', 'recipes.edit')
        ->name('recipes.edit');
});



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
