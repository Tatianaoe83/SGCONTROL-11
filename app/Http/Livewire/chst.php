<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Prism\Prism\Prism;

class ChatBotComponent extends Component
{
    public $input = '';
    public $messages = [];
    public $streamedResponse = '';
    public $isTyping = false;

    public function send()
    {
        $prompt = $this->input;

        // Add user message to messages array immediately
        $this->messages[] = ['user' => 'You', 'text' => $prompt];
        $this->input = '';

        // Reset streamed response and set typing state
        $this->streamedResponse = '';
        $this->isTyping = true;

        // Dispatch UI updates first
        $this->dispatch('scroll-down');

        // Dispatch the event to trigger the AI response
        $this->dispatch('getAiResponse', $prompt);
    }

    #[On('getAiResponse')]
    public function getAIResponse($prompt)
    {
        $this->streamResponse($prompt);
    }

    public function streamResponse($prompt)
    {
        
        logger()->info('Sending request to Prism:', ['prompt' => $prompt]);

       /* $stream = Prism::text()
           ->using('openai', 'gpt-4')
            ->withPrompt($prompt)
            ->asStream();*/

            try {
                $stream = Prism::text()
                ->using('openai', 'gpt-4.1-mini')
                    //->withPrompt('Tell me a story about a brave knight.')
                    ->withPrompt($prompt)
                    ->asStream();
            } catch (\Exception $e) {
                logger()->error('Prism API error: ' . $e->getMessage());
            }

       

        foreach ($stream as $chunk) {
            // Stream only new chunk text
            $this->stream('response', $chunk->text);

            
            // Accumulate full response for storage
            $this->streamedResponse .= $chunk->text;
        }

        // Add completed response to messages array
        $this->messages[] = ['user' => 'AI', 'text' => $this->streamedResponse];

        // Reset streaming state
        $this->streamedResponse = '';
        $this->isTyping = false;

        $this->dispatch('scroll-down');
    }

    public function render()
    {
        return view('livewire.chat-bot');
    }
}

