<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\NewGameForm;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');


// Game
Route::get('/new-game', NewGameForm::class)->name('new-game');
