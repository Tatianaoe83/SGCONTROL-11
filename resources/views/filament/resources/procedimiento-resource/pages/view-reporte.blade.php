<x-filament::page>
    <div class="prose max-w-4xl mx-auto">
        @php
        \Log::info($this->record);
         $procedimiento = \App\Models\Procedimiento::find($this->record);
         @endphp

        <h1 class="text-center text-2xl font-bold">{{ $procedimiento->NombreProcedimiento }}</h1>
        <p><strong>Folio:</strong> {{ $procedimiento->FolioProcedimientos }}</p>
        <p><strong>Versión:</strong> {{ $procedimiento->Version }}</p>
        <p><strong>División:</strong> {{ $procedimiento->Division }}</p>
        <p><strong>Unidad de Negocio:</strong> {{ $procedimiento->UnidadNegocio }}</p>
        <p><strong>Fecha de Emisión:</strong> {{ $procedimiento->fechaEmision }}</p>

        <hr>

        @foreach ($procedimiento->blocks as $block)
            <h2 class="text-xl font-semibold mt-6">{{ $block->titulo }}</h2>
            <div class="border p-4 bg-gray-50 rounded">{!! $block->descripcion !!}</div>
        @endforeach

        <hr class="my-6">

        <h2 class="text-xl font-semibold">Firmas</h2>
        <ul>
            @foreach ($procedimiento->procedimiento_firmas as $firma)
                <li>{{ $firma->firma->nombre ?? 'Sin nombre' }}</li>
            @endforeach
        </ul>
    </div>
</x-filament::page>