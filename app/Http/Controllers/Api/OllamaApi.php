<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Client\ConnectionException;

class OllamaApi extends Ollama
{

    /**
     * @param string $userPrompt Prompt que sera enviada para a LLM
     *
     * @return string Resposta Da LLM
     * @throws ConnectionException
     */
    public static function Prompt(string $userPrompt, string $systemRole = null): string
    {
        $apiInterface = new self('llama3.2', 'http://localhost:11434', 'api/chat');
        $systemRole = $systemRole ?: "Você é o criador de um jogo da forca. Baseado no texto que o usuário enviar, me retorne APENAS um json com os seguintes dados: {keyword: 'string (a palavra que sera usada no jogo da forca)',tips: 'string (dicas para a keyword)'}";
        $apiInterface->addRole([
            'role' => 'system',
            'content' => $systemRole,
        ]);
        $apiInterface->addRole([
            'role' => 'user',
            'content' => $userPrompt,
        ]);
        $apiInterface->jsonResponse(true);

        return $apiInterface->sendPrompt($userPrompt);
    }
}
