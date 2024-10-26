<?php

use App\Livewire\Pages\Home;
use App\Livewire\Pages\ListGames;
use App\Livewire\Pages\Login;
use App\Livewire\Pages\NewGameForm;
use App\Livewire\Pages\PlayGame;
use App\Livewire\Pages\Register;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

// Game
Route::group(['middleware' => ['auth']], function () {
    Route::get('/game/{id}', PlayGame::class)->name('game');
    Route::get('/new-game', NewGameForm::class)->name('new-game');
    Route::get('/list-games', ListGames::class)->name('list-games');
});

// Auth
Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('home');
})->name('logout');
