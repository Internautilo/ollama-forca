<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

abstract class Ollama
{
    protected string $model;
    protected string $url;
    protected bool $stream = false;
    protected array $payload;

    function __construct(string $model, string $url, string $endpoint = null)
    {
        $this->model = $model;
        if ($endpoint && !str_ends_with($url, '/')) {
            if (!str_starts_with($endpoint, '/')) {
                $url .= '/';
            }
        }
        $this->url = ($endpoint) ? $url . $endpoint : $url;
    }

    public function streamResponse(bool $stream): void
    {
        $this->stream = $stream;
    }

    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    protected function setPrompt(string $prompt): void
    {
        $data = [
            'model' => $this->model,
            "prompt" => $prompt,
            'stream' => $this->stream,
        ];

        $this->payload = $data;
    }


    /**
     * @param string $prompt Prompt que sera enviada para a LLM
     *
     * @return string Resposta Da LLM
     * @throws ConnectionException
     */
    public function sendPrompt(string $prompt): string
    {
        $this->setPrompt($prompt);
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->url, $this->payload);

            $jsonResponse = $response->json();
            return $jsonResponse['response'] ?? 'No response from the API'; // Default value if 'response' key doesn't exist
        } catch (\Exception $e) {
            throw new ConnectionException('Failed to connect to the API: ' . $e->getMessage());
        }
    }

}
