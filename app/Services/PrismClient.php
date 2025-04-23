<?php

namespace App\Services;

use Prism\Prism\Prism;

class PrismClient
{
    public function chat(array $messages): ?string
    {
        try {
            $response = Prism::text()
                ->chat()
                ->model('gpt-3.5-turbo') 
                ->create([
                    'messages' => $messages,
                ]);

            return $response->toArray()['choices'][0]['message']['content'] ?? null;
        } catch (\Throwable $e) {
            logger()->error('Prism Error: ' . $e->getMessage());
            return null;
        }
    }
}
