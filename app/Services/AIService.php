<?php

namespace App\Services;

use App\Services\PrismClient;

class AIService
{
    protected $client;

    public function __construct(PrismClient $client)
    {
        $this->client = $client;
    }

    public function chat(string $prompt): string
    {
        $response = $this->client->chat([
            ['role' => 'system', 'content' => 'Eres un asistente que ayuda a buscar información interna en documentos y base de datos.'],
            ['role' => 'user', 'content' => $prompt],
        ]);

        return $response ?? 'No se pudo procesar tu solicitud.';
    }
}
