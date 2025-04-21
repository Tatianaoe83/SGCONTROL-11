<x-filament::page>
    <div>
        <div id="three-container"></div>

        <div id="chat-container">
            <livewire:chat-bot-component />
        </div>
    </div>

    @push('styles')
    <style>
    #three-container {
        width: 100%;
        height: 90vh;
        position: relative;
    }

    #chat-container {
        position: absolute;
        top: 14rem;
        right: 35rem;
        width: 506px;
        background: rgba(255, 255, 255, 0.85);
        padding: 1rem;
        border-radius: 1rem;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        z-index: 10;
        backdrop-filter: blur(10px);
    }

    #chat-box {
        height: 150px;
        overflow-y: auto;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    #user-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 0.5rem;
    }
</style>
    @endpush

    @push('scripts')
        {{-- Script Three.js como módulo separado --}}
        <script type="module" src="{{ asset('js/three-avatar.js') }}"></script>
    @endpush
</x-filament::page>