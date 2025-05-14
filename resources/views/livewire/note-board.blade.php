
<div class="grid grid-cols-2 gap-4 p-6">
    @foreach ([1 => 'Procedimientos', 2 => 'Politicas'] as $s => $label)
        <div class="bg-white rounded shadow p-4">
            <div class="flex justify-between mb-4">
                <h2 class="text-xl font-bold">{{ $label }}</h2>
                <button wire:click="createNote({{ $s }})"
                        class="bg-blue-500 text-white text-sm px-3 py-1 rounded hover:bg-blue-600">
                    + Nota
                </button>
            </div>

            <ul wire:sortable="updateOrder({{ $s }})" class="space-y-2 min-h-[100px]">
                @foreach (${'section' . $s} as $note)
                    <li wire:key="note-{{ $note['idNote'] }}"
                        wire:sortable.item="{{ $note['idNote'] }}"
                        class="bg-gray-100 p-3 rounded shadow flex justify-between items-start">
                        
                        <div wire:sortable.handle class="cursor-move flex-1">
                            <strong>{{ $note['order'] }}</strong>
                            <p class="text-sm text-gray-700">{{ $note['content'] }}</p>
                        </div>

                        <div class="ml-2 flex flex-col items-end space-y-1">
                            <button wire:click="editNote({{ $note['idNote'] }})"
                                    class="text-blue-600 text-xs underline">
                                Editar
                            </button>
                            <button wire:click="confirmDelete({{ $note['idNote'] }})"
                                    class="text-red-600 text-xs underline">
                                Eliminar
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach

    {{-- Modal de Crear/Editar --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-30 z-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-md p-6 rounded shadow-xl">
                <h2 class="text-lg font-bold mb-4">
                    {{ $editingNote ? 'Editar Nota' : 'Nueva Nota' }}
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium">Título</label>
                        <input type="text" wire:model.defer="title"
                               class="w-full border rounded px-3 py-1" />
                        @error('title') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Contenido</label>
                        <textarea wire:model.defer="content"
                                  class="w-full border rounded px-3 py-1"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Sección</label>
                        <select wire:model.defer="section" class="w-full border rounded px-3 py-1">
                            <option value="1">Sección 1</option>
                            <option value="2">Sección 2</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="$set('showModal', false)" class="px-3 py-1 text-gray-600">
                        Cancelar
                    </button>
                    <button wire:click="saveNote"
                            class="ml-3 bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Confirmación de Eliminación --}}
    @if ($deleteId)
        <div class="fixed inset-0 bg-black bg-opacity-30 z-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow w-full max-w-sm">
                <h2 class="text-lg font-semibold mb-4">¿Eliminar esta nota?</h2>
                <div class="flex justify-end space-x-2">
                    <button wire:click="$set('deleteId', null)" class="px-3 py-1 text-gray-600">
                        Cancelar
                    </button>
                    <button wire:click="deleteNote"
                            class="px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                        Eliminar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
