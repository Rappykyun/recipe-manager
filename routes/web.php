<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

<<<<<<< HEAD
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Volt::route('recipes', 'recipes.index')->name('recipes.index');
    Volt::route('recipes/public/{recipe}', 'recipes.public')->name('recipes.public');
});


=======
// Recipe routes
Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('recipes', 'recipes.index')->name('recipes.index');
    Volt::route('recipes/public/{recipe}', 'recipes.public')->name('recipes.public');
});
>>>>>>> f1ab130b3ba0c014929c0b524b2c54be0100b95d

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
