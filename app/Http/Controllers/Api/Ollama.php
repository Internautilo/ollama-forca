<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

abstract class Ollama
{
    protected string $model;
    protected string $url;
    protected bool $stream = false;
    protected bool $jsonResponse = false;
    protected array $payload;
    protected array $roles = [];

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

    public function jsonResponse(bool $jsonResponse): void
    {
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * @param array $role ['role' => 'user', 'content' => 'message]
     *
     * @return void
     */
    public function addRole(array $role): void
    {
        $newRole = new \stdClass();
        $newRole->role = $role['role'];
        $newRole->content = $role['content'];

        $this->roles[] = $newRole;
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
            'stream' => $this->stream,
            'keep_alive' => 0,
            "prompt" => $prompt,
        ];

        if (count($this->roles) > 0) {
            unset($data['prompt']);
            $data['messages'] = $this->roles;
        }

        if ($this->jsonResponse) {
            $data['format'] = 'json';
        }

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
            if ($jsonResponse['message']) {
                return $jsonResponse['message']['content'] ?? 'No response from the API';
            }
            return $jsonResponse['response'] ?? 'No response from the API';
        } catch (\Exception $e) {
            throw new ConnectionException('Failed to connect to the API: ' . $e->getMessage());
        }
    }

}
