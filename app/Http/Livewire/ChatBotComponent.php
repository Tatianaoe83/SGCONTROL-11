<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\AIService;

class ChatBotComponent extends Component
{
    public $userMessage = '';
    public $messages = [];

    public function sendMessage()
    {
        if (trim($this->userMessage) === '') {
            return;
        }

        $this->messages[] = [
            'role' => 'user',
            'text' => $this->userMessage,
        ];

        $userInput = $this->userMessage;
        $this->userMessage = '';


        $aiService = app(AIService::class);

        $aiReply = $aiService->chat($userInput);

        $this->messages[] = [
            'role' => 'assistant',
            'text' => $aiReply,
        ];
    }

    public function render()
    {
        return view('livewire.chat-bot');
    }
}
