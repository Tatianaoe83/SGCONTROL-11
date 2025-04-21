<div>
    <div id="chat-box" class="h-40 overflow-y-auto bg-white p-3 rounded shadow mb-2 text-sm">
        @foreach ($messages as $message)
            <div class="mb-1 {{ $message['role'] === 'user' ? 'text-right' : 'text-left' }}">
                <strong>{{ $message['role'] === 'user' ? 'Tú' : 'Asistente' }}:</strong>
                <span class="inline-block p-2 rounded {{ $message['role'] === 'user' ? 'bg-blue-100' : 'bg-gray-100' }}">
                    {{ $message['text'] }}
                </span>
            </div>
        @endforeach
    </div>

    <input type="text"
           wire:model="userMessage"
           wire:keydown.enter="sendMessage"
           placeholder="Escribe algo..."
           class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-transparent">
</div>
