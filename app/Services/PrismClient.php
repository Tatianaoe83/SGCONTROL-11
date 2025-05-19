<?php
namespace App\Services;
use Prism\Prism\Prism;

class PrismClient
{
    public function chat(array $messages): ?string
    {
        
        $formattedPrompt = '';
        foreach ($messages as $message) {
            $formattedPrompt .= ucfirst($message['role']) . ': ' . $message['content'] . "\n";
        }

        logger()->info('Sending request to Prism:', ['formattedPrompt' => $formattedPrompt]);

        try {
           
            $response = Prism::text()
                ->using('ollama', 'llama3.1')
                ->withPrompt($formattedPrompt)
                ->asStream();  

            $responseContent = '';

            foreach ($response as $chunk) {
                if (!empty($chunk->text)) {
                    $responseContent .= $chunk->text;  
                }
            }

            return $responseContent;

        } catch (\Exception $e) {
            logger()->error('Prism API error: ' . $e->getMessage());
            return null;
        }
    }
}
