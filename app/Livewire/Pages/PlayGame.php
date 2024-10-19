<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;

class PlayGame extends Component
{
    public string|int $id;
    public Game $game;

    public function mount($id = null)
    {
        if (is_null($id)) {
            $this->redirectRoute('list-games');
            return;
        }
        $this->id = $id;
        $this->game = Game::find($this->id);
    }

    public function render()
    {
        return view('livewire.pages.play-game');
    }
}
