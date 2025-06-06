<x-filament::page>
    <div class="w-full max-w-5xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8 border-b pb-6">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-16 object-contain">
            <div class="bg-gray-400 text-black px-8 py-4 text-lg font-bold tracking-wide uppercase">Manual de políticas</div>
        </div>

        <div class="mb-10">
            <div class="grid grid-cols-2 gap-8 text-sm">
                <div class="space-y-3">
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Folio:</span>
                        <span class="text-gray-900">{{ $this->politica->Foliopoliticas }}</span>
                    </p>
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Versión:</span>
                        <span class="text-gray-900">{{ $this->politica->Version }}</span>
                    </p>
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">División:</span>
                        <span class="text-gray-900">{{ $this->politica->Division }}</span>
                    </p>
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Unidad de Negocio:</span>
                        <span class="text-gray-900">{{ $this->politica->UnidadNegocio }}</span>
                    </p>
                </div>
                <div class="space-y-3">
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Fecha de Emisión:</span>
                        <span class="text-gray-900">{{ $this->politica->fechaEmision }}</span>
                    </p>
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Proceso:</span>
                        <span class="text-gray-900">{{ $this->politica->proceso[0]->DescripcionProcesos ?? 'Sin proceso' }}</span>
                    </p>
                    <p class="flex justify-between border-b pb-2">
                        <span class="font-semibold text-gray-700">Procedimiento:</span>
                        <span class="text-gray-900">{{ $this->politica->NombreProcedimiento }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="space-y-8 mb-12">
            @foreach ($this->politica->blocksPolitica as $block)
                <div class="bg-white rounded-lg border border-gray-200 p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3">{{ $block->titulo }}</h2>
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! $block->descripcion !!}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 mb-16">
            <h2 class="text-xl font-bold text-gray-800 mb-8 border-b pb-3">Firmas</h2>
            <div class="grid grid-cols-2 gap-8">
                @foreach ($this->politica->politica_firmas->sortBy('firma.nombre') as $firma)
                    <div class="border-t-2 border-gray-300 pt-6">
                        <p class="font-bold text-gray-800">{{ $firma->user->name ?? 'Sin usuario' }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $firma->firma->nombre ?? 'Sin asignación' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="text-center text-sm mt-20 border-t pt-8">
            <p class="text-gray-600">Los documentos actualizados y autorizados del SGC, se encuentran únicamente en el portal del SGC</p>
            <div class="mt-4 pt-4 border-t border-gray-300">
                <p class="font-semibold text-gray-800">Documento Interno PROSER - CONFIDENCIAL</p>
            </div>
        </div>

        <style>
            @media print {
                .filament-header,
                .filament-sidebar {
                    display: none !important;
                }
                .filament-main {
                    padding: 0 !important;
                    margin: 0 !important;
                    max-width: none !important;
                }
                .prose {
                    max-width: none !important;
                }
                body {
                    margin: 0 !important;
                    padding: 0 !important;
                }
                .w-full {
                    width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
            }
        </style>
    </div>
</x-filament::page>