<div class="flex flex-col h-screen bg-gray-900 text-gray-200 py-8">
    <div class="flex-1 overflow-y-auto px-4 space-y-4" id="messages">
        @foreach($messages as $message)
            <div class="flex {{ $message['user'] === 'You' ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-md">
                    <div class="{{ $message['user'] === 'You' ? 'bg-indigo-600' : 'bg-gray-700' }} shadow rounded-xl p-3">
                        <p class="text-sm whitespace-pre-wrap">
                            {{ $message['text'] }}
                        </p>
                    </div>
                    <span class="block text-xs mt-1 text-gray-400 {{ $message['user'] === 'You' ? 'text-right' : 'text-left' }}">
                        {{ $message['user'] }}
                    </span>
                </div>
            </div>
        @endforeach

        <!-- Container for streaming response - only shown when typing -->
        @if($isTyping)
            <div class="flex justify-start">
                <div class="max-w-md">
                    <div class="bg-gray-700 shadow rounded-xl p-3">
                        <p class="text-sm whitespace-pre-wrap" wire:stream="response">
                            <!-- Streamed content will appear here -->
                        </p>
                    </div>
                    <span class="block text-xs mt-1 text-gray-400 text-left">
                        AI
                    </span>
                </div>
            </div>
        @endif
    </div>

    <div class="px-4 pt-4 border-t border-gray-700">
        <form wire:submit.prevent="send" class="flex space-x-2">
            <input type="text"
                   wire:model.defer="input"
                   placeholder="Ask something..."
                   class="w-full rounded-lg border border-gray-700 bg-gray-800 text-gray-200 placeholder-gray-500 p-3 shadow focus:ring-indigo-500 focus:border-indigo-500"
                   required />
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg px-5 shadow transition"
            >
                Send
            </button>
        </form>
    </div>
</div>