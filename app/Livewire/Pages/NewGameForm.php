<?php

namespace App\Livewire\Pages;

use App\Http\Controllers\Api\OllamaApi;
use App\Models\Game;
use Livewire\Component;

class NewGameForm extends Component
{
    public string $theme = '';

    public function render()
    {
        return view('livewire.pages.new-game-form');
    }

    /**
     *
     * @throws \Exception
     */
    public function save(): void
    {
        if (!auth()->check()) {
            throw new \Exception('User is not authenticated');
        }

        if ($this->theme !== '') {
            try {
                $response = OllamaApi::Prompt($this->theme);
                $gameId = Game::create([
                    'keyword' => $response,
                    'user_id' => auth()->id(),
                ]);

                $this->dispatch('game-created', ['gameId' => $gameId]);
            } catch (\Exception $e) {
                throw new \Exception("Failed to connect to the API: " . $e->getMessage());
            }
        }
    }
}
