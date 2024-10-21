<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;

class PlayGame extends Component
{
    public string|int $id;
    public Game $game;

    public $listeners = [
        'redirect-to-route' => 'redirectRoute'
    ];

    public function mount($id = null)
    {
        if (is_null($id)) {
            $this->redirectRoute('list-games');
            return;
        }
        $this->id = $id;
        $this->game = Game::findOrFail($this->id);
    }

    public function render()
    {
        return view('livewire.pages.play-game');
    }

    public function addLetter(string $letter): void
    {
        $letters = $this->game->correct_letters;
        $letters .= ',' . $letter;
        $letters = strtoupper($letters);

        $this->game->correct_letters = $letters;
        $this->game->save();
    }
}
