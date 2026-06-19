<div class="container mx-auto max-w-4xl py-10 px-4">

    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

        <div class="bg-primary-600 text-white p-6">
            <h1 class="text-3xl font-bold">
                Agendamiento de Citas
            </h1>

            <p class="mt-2 text-sm opacity-90">
                Ingrese su código para consultar las fechas disponibles.
            </p>
        </div>

        <div class="p-6">

            {{-- Mensaje éxito --}}
            @if (session()->has('success'))
                <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- VALIDACIÓN DE CÓDIGO --}}
            @if (!$mostrarAgenda)

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Código del Cliente
                        </label>

                        <input
                            type="text"
                            wire:model="codigo"
                            placeholder="Ej: ADUL-15"
                            class="w-full border rounded-lg p-3"
                        >

                        @error('codigo')
                            <span class="text-red-500 text-sm">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <button
                        wire:click="validarCodigo"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
                    >
                        Validar Código
                    </button>

                </div>

            @endif

            {{-- INFORMACIÓN CLIENTE --}}
            @if ($mostrarAgenda && $customer)

                <div class="mb-6 p-5 rounded-xl bg-gray-50 border">

                    <h3 class="text-lg font-semibold mb-3">
                        Información del Cliente
                    </h3>

                    <div class="grid md:grid-cols-2 gap-3">

                        <div>
                            <strong>Nombre:</strong>
                            {{ $customer->Nombre }}
                        </div>

                        <div>
                            <strong>Teléfono:</strong>
                            {{ $customer->Telefono }}
                        </div>

                        <div>
                            <strong>Tipo:</strong>
                            {{ $customer->Tipo }}
                        </div>

                        <div>
                            <strong>Código:</strong>
                            {{ $customer->CodigoCustomer }}
                        </div>

                    </div>

                </div>

                {{-- FECHAS --}}
                <div class="mb-8">

                    <h3 class="text-lg font-semibold mb-4">
                        Seleccione una fecha
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                        @foreach($fechas as $fecha)

                            <button
                                type="button"
                                wire:click="$set('fechaSeleccionada', '{{ $fecha->AvailableDate }}')"
                                class="
                                    border
                                    rounded-lg
                                    p-3
                                    text-center
                                    transition

                                    {{ $fechaSeleccionada == $fecha->AvailableDate
                                        ? 'bg-blue-600 text-white border-blue-600'
                                        : 'bg-white hover:bg-gray-100'
                                    }}
                                "
                            >
                                {{ \Carbon\Carbon::parse($fecha->AvailableDate)->format('d/m/Y') }}
                            </button>

                        @endforeach

                    </div>

                </div>

                {{-- HORARIOS --}}
                @if($fechaSeleccionada)

                    <div class="mb-8">

                        <h3 class="text-lg font-semibold mb-4">
                            Horarios disponibles
                        </h3>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">

                            @forelse($horarios as $horario)

                                <button
                                    type="button"
                                    wire:click="$set('horarioSeleccionado', '{{ $horario->IdAvailability }}')"
                                    class="
                                        border
                                        rounded-lg
                                        p-3
                                        text-center
                                        transition

                                        {{ $horarioSeleccionado == $horario->IdAvailability
                                            ? 'bg-green-600 text-white border-green-600'
                                            : 'bg-white hover:bg-gray-100'
                                        }}
                                    "
                                >
                                    {{ \Carbon\Carbon::parse($horario->AvailableTime)->format('H:i') }}
                                </button>

                            @empty

                                <div class="col-span-full text-gray-500">
                                    No hay horarios disponibles.
                                </div>

                            @endforelse

                        </div>

                    </div>

                @endif

                {{-- BOTÓN AGENDAR --}}
                @if($horarioSeleccionado)

                    <div class="text-center">

                        <button
                            wire:click="guardarCita"
                            wire:loading.attr="disabled"
                            class="
                                bg-green-600
                                hover:bg-green-700
                                text-white
                                px-8
                                py-4
                                rounded-xl
                                font-semibold
                            "
                        >
                            Confirmar Cita
                        </button>

                    </div>

                @endif

            @endif

        </div>

    </div>

</div>