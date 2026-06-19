<x-filament::page>

    {{-- 🔎 FILTROS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

        <input type="date" wire:model="fechaInicio"
            class="fi-input w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">

        <input type="date" wire:model="fechaFin"
            class="fi-input w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">

        <select wire:model="estadoProceso"
            class="fi-select w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
            <option value="">Estado Proceso</option>
            <option>En Proceso</option>
            <option>Decorado</option>
            <option>Entregado</option>
        </select>

        <select wire:model="estadoCliente"
            class="fi-select w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-white">
            <option value="">Estado Cliente</option>
            <option>Pago</option>
            <option>Debe</option>
        </select>

    </div>

    {{-- 🔘 BOTONES --}}
    <div class="mb-6 flex flex-wrap gap-2">

        <button wire:click="buscar"
            class="px-4 py-2 rounded-lg bg-primary-600 text-white hover:bg-primary-500 transition">
            Buscar
        </button>

        <button wire:click="exportExcel"
            class="px-4 py-2 rounded-lg bg-success-600 text-white hover:bg-success-500 transition">
            Excel
        </button>

        <button wire:click="exportPdf"
            class="px-4 py-2 rounded-lg bg-danger-600 text-white hover:bg-danger-500 transition">
            PDF
        </button>

    </div>

    {{-- 📊 TABLA --}}
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr class="text-left text-gray-700 dark:text-gray-200">
                    <th class="p-3">Nombre</th>
                    <th class="p-3">Teléfono</th>
                    <th class="p-3">Estado Cliente</th>
                    <th class="p-3">Estado Proceso</th>
                    <th class="p-3">Fecha</th>
                </tr>
            </thead>

            <tbody>
                @forelse($resultados as $item)
                    @php $proceso = $item->processes->first(); @endphp

                    <tr class="border-t border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                        <td class="p-3 text-gray-800 dark:text-gray-100">
                            {{ $item->Nombre }}
                        </td>

                        <td class="p-3 text-gray-600 dark:text-gray-300">
                            {{ $item->Telefono }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $item->EstadoCustomer === 'Pago'
                                    ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                    : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                {{ $item->EstadoCustomer }}
                            </span>
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $proceso?->Estado === 'Entregado'
                                    ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'
                                    : ($proceso?->Estado === 'Derivado'
                                        ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300'
                                        : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300') }}">
                                {{ $proceso->Estado ?? 'Sin proceso' }}
                            </span>
                        </td>

                        <td class="p-3 text-gray-600 dark:text-gray-300">
                            {{ $proceso->Fecha ?? '-' }}
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400">
                            No hay resultados
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</x-filament::page>