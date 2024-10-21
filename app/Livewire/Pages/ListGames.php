<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class ListGames extends Component
{
    public array|Collection $games = [];

    public function render(): View
    {
        return view('livewire.pages.list-games');
    }

    public function mount(): void
    {
        $this->loadGames();
    }

    private function loadGames():void
    {
        $this->games = Game::All();
    }

    public function deleteGame($id): void
    {
        Game::destroy($id);
        $this->loadGames();
    }
}
