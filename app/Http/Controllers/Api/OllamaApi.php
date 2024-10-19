<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Client\ConnectionException;

class OllamaApi extends Ollama
{

    /**
     * @param string $prompt Prompt que sera enviada para a LLM
     *
     * @return string Resposta Da LLM
     * @throws ConnectionException
     */
    public static function Prompt(string $prompt): string
    {
        $apiInterface = new self('llama3.2', 'http://localhost:11434', 'api/generate');
        $prompt .= ". Me responda uma única palavra que tenha relação com o tema que foi descrito anteriormente";

        return $apiInterface->sendPrompt($prompt);
    }
}
