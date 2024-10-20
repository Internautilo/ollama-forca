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
//        if (!auth()->check()) {
//            throw new \Exception('User is not authenticated');
//        }

        if ($this->theme !== '') {
            try {
                $response = OllamaApi::Prompt($this->theme);
                $response = json_decode($response, true);
                $game = Game::create([
                    'keyword' => preg_replace('/[^A-Z]/i', '', strtoupper($response['keyword'])),
                    'theme' => $this->theme,
                    'tips' => $response['tips'],
                    'user_id' => auth()->id(),
                ]);

                $this->redirectRoute('game', ['id' => $game->id]);
            } catch (\Exception $e) {
                throw new \Exception("Failed to connect to the API: " . $e->getMessage());
            }
        }
    }
}
