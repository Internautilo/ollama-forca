<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Illuminate\Support\Collection;
use Livewire\Component;

class Home extends Component
{
    public array|Collection $games;

    public function render()
    {
        return view('livewire.pages.home');
    }

    public function mount()
    {
        if (auth()->check()) {
            $this->games = Game::where(['user_id' => auth()->id()])->limit(3)->get();
        } else {
            $this->games = Game::where(['deleted_at' => null])->orderByDesc('id')->get();
        }
    }
}
