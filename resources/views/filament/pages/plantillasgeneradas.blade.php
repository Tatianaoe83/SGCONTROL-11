<x-filament::page>
    <x-filament::tabs>
        <x-filament::tabs.item
            wire:click="$set('section', 1)"
            :active="$section === 1"
        >
            Procedimientos
        </x-filament::tabs.item>
        <x-filament::tabs.item
            wire:click="$set('section', 2)"
            :active="$section === 2"
        >
            Políticas
        </x-filament::tabs.item>
    </x-filament::tabs>

    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament::page>
