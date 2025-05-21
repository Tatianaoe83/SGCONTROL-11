
<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-6 max-w-xl">
        {{ $this->form }}

        <x-filament::button type="submit" color="primary">
            Enviar propuesta
        </x-filament::button>
    </form>
</x-filament::page>
