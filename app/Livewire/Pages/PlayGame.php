<?php

namespace App\Livewire\Pages;

use App\Models\Game;
use Livewire\Component;

class PlayGame extends Component
{
    public string|int $id;
    public Game $game;
    public string $toast;

    public $listeners = [
        'redirect-to-route' => 'redirectRoute',
        'add-try' => 'addTry',
        'add-correct-letter' => 'addCorrectLetter',
        'go-back-on-finish' => 'goBackOnFinish',
    ];

    public function mount($id = null, $toast = null)
    {
        if (is_null($id)) {
            $this->redirectRoute('list-games');
            return;
        }
        $this->id = $id;
        $this->game = Game::findOrFail($this->id);
        if (!is_null($toast)) {
            $this->toast = $toast;
        }
    }

    public function render()
    {
        return view('livewire.pages.play-game');
    }

    public function addCorrectLetter(string $letter, string $toast = ''): void
    {
        $letters = $this->game->correct_letters;
        $letters .= (($letters == '') ? $letter : ',' . $letter);
        $letters = strtoupper($letters);

        $this->game->correct_letters = $letters;
        $this->game->save();
        $this->addTry($letter, $toast);
    }

    public function addTry(string $letter, string $toast = ''): void
    {
        $letters = $this->game->tries;
        $letters .= (($letters == '') ? $letter : ',' . $letter);
        $letters = strtoupper($letters);

        $this->game->tries = $letters;
        $this->game->save();
        $this->redirectRoute('game', ['id' => $this->id, 'toast' => $toast], navigate: true);
    }

    public function goBackOnFinish(string $letter): void
    {
        $letters = $this->game->tries;
        $letters .= (($letters == '') ? $letter : ',' . $letter);
        $letters = strtoupper($letters);
        $this->game->tries = $letters;

        $letters = $this->game->correct_letters;
        $letters .= (($letters == '') ? $letter : ',' . $letter);
        $letters = strtoupper($letters);
        $this->game->correct_letters = $letters;

        $this->game->save();

        $this->redirectRoute('list-games', navigate: true);
    }
}
