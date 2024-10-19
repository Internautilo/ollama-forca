<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\ListGames;
use App\Livewire\Pages\NewGameForm;
use App\Livewire\Pages\PlayGame;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');


// Game
Route::get('/game/{id}', PlayGame::class)->name('game');
Route::get('/new-game', NewGameForm::class)->name('new-game');
Route::get('/list-games', ListGames::class)->name('list-games');
