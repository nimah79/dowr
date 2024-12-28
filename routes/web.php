<?php

use Illuminate\Support\Facades\Route;

Route::get('/register', \App\Livewire\RegisterForm::class)
    ->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', \App\Livewire\CreateGame::class)
        ->name('game.create');

    Route::get('/lobby/{game}', \App\Livewire\GameLobby::class)
        ->name('game.lobby');

    Route::get('/game/{game}', \App\Livewire\GamePage::class)
        ->name('game.page');
});
