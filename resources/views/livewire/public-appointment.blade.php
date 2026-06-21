<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 flex items-start sm:items-center justify-center p-4 sm:p-8 font-sans text-gray-800">

    <div class="w-full max-w-4xl bg-white/80 backdrop-blur-xl shadow-2xl rounded-[2rem] overflow-hidden border border-white/60">

        {{-- Encabezado con branding --}}
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white p-8 sm:p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
            <div class="absolute inset-0 opacity-20 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmZmZmYiLz48L3N2Zz4=')] bg-[length:20px_20px]"></div>
            
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight relative z-10 drop-shadow-lg">
                FlowAccess
            </h1>
            <p class="mt-3 text-lg sm:text-xl font-medium text-indigo-100 relative z-10">
                Portal de Agendamiento
            </p>
        </div>

        <div class="p-6 sm:p-10">

            {{-- Mensaje éxito --}}
            @if (session()->has('success'))
                <div class="mb-8 p-5 rounded-2xl bg-green-50 text-green-800 border border-green-200 shadow-sm flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium text-lg">{{ session('success') }}</span>
                </div>
            @endif

            {{-- VALIDACIÓN DE CÓDIGO --}}
            @if (!$mostrarAgenda)
                <div class="max-w-md mx-auto py-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800">¡Bienvenido!</h2>
                        <p class="text-gray-500 mt-2">Ingresa tu código de cliente para continuar con el proceso de agendamiento.</p>
                    </div>

                    <div class="space-y-6 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Código del Cliente
                            </label>
                            <input
                                type="text"
                                wire:model="codigo"
                                placeholder="Ej: ADUL-15"
                                class="w-full border-gray-300 rounded-xl p-4 bg-gray-50 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:bg-white transition shadow-inner font-medium"
                            >
                            @error('codigo')
                                <div class="mt-2 text-red-500 text-sm flex items-center gap-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button
                            wire:click="validarCodigo"
                            wire:loading.attr="disabled"
                            class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-4 rounded-xl font-bold text-lg shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2"
                        >
                            <span wire:loading.remove wire:target="validarCodigo">Validar Código</span>
                            <span wire:loading wire:target="validarCodigo">Validando...</span>
                            <svg wire:loading.remove wire:target="validarCodigo" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            @endif

            {{-- INFORMACIÓN CLIENTE Y AGENDA --}}
            @if ($mostrarAgenda && $customer)
                <div class="mb-10 p-6 rounded-2xl bg-gradient-to-br from-gray-50 to-indigo-50 border border-indigo-100 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500 opacity-5 rounded-full -mr-10 -mt-10 blur-xl"></div>
                    <div class="flex items-center gap-3 mb-4 relative z-10">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">
                            Tu Información
                        </h3>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-4 relative z-10">
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Nombre</p>
                            <p class="font-medium text-gray-900 mt-0.5 truncate" title="{{ $customer->Nombre }}">{{ $customer->Nombre }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Teléfono</p>
                            <p class="font-medium text-gray-900 mt-0.5 truncate">{{ $customer->Telefono }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Tipo</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->Tipo == 'Adulto' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }} mt-1">
                                {{ $customer->Tipo }}
                            </span>
                        </div>
                        <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Código</p>
                            <p class="font-medium text-indigo-600 font-mono mt-0.5 truncate">{{ $customer->CodigoCustomer }}</p>
                        </div>
                    </div>
                </div>

                {{-- FECHAS --}}
                <div class="mb-10">
                    <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center gap-2">
                        <span class="bg-indigo-100 text-indigo-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span>
                        Selecciona una fecha
                    </h3>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($fechas as $fecha)
                            <button
                                type="button"
                                wire:click="$set('fechaSeleccionada', '{{ $fecha->AvailableDate }}')"
                                class="
                                    relative p-4 rounded-2xl transition-all duration-200 border-2 text-center group font-medium cursor-pointer shadow-sm
                                    {{ $fechaSeleccionada == $fecha->AvailableDate
                                        ? 'bg-indigo-50 border-indigo-500 text-indigo-700 shadow-md ring-2 ring-indigo-500 ring-offset-2'
                                        : 'bg-white border-gray-200 hover:border-indigo-300 hover:bg-indigo-50/50 hover:text-indigo-600 text-gray-600 hover:shadow'
                                    }}
                                "
                            >
                                <span class="block text-2xl font-bold mb-1">
                                    {{ \Carbon\Carbon::parse($fecha->AvailableDate)->format('d') }}
                                </span>
                                <span class="block text-xs uppercase tracking-wider {{ $fechaSeleccionada == $fecha->AvailableDate ? 'text-indigo-600' : 'text-gray-500 group-hover:text-indigo-500' }}">
                                    {{ ucfirst(\Carbon\Carbon::parse($fecha->AvailableDate)->translatedFormat('M y')) }}
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- HORARIOS --}}
                @if($fechaSeleccionada)
                    <div class="mb-10 animate-fade-in-up">
                        <h3 class="text-xl font-bold text-gray-800 mb-5 flex items-center gap-2">
                            <span class="bg-purple-100 text-purple-700 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span>
                            Elige un horario
                        </h3>

                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                            @forelse($horarios as $horario)
                                <button
                                    type="button"
                                    wire:click="$set('horarioSeleccionado', '{{ $horario->IdAvailability }}')"
                                    class="
                                        px-4 py-3 rounded-xl transition-all duration-200 text-center font-bold border-2 cursor-pointer shadow-sm
                                        {{ $horarioSeleccionado == $horario->IdAvailability
                                            ? 'bg-purple-600 border-purple-600 text-white shadow-md ring-2 ring-purple-600 ring-offset-2 transform scale-105'
                                            : 'bg-white border-gray-200 text-gray-700 hover:border-purple-300 hover:bg-purple-50 hover:text-purple-700'
                                        }}
                                    "
                                >
                                    {{ \Carbon\Carbon::parse($horario->AvailableTime)->format('H:i') }}
                                </button>
                            @empty
                                <div class="col-span-full py-8 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p class="text-gray-500 font-medium">No hay horarios disponibles para esta fecha.</p>
                                    <p class="text-sm text-gray-400 mt-1">Por favor, intenta seleccionando un día distinto.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif

                {{-- BOTÓN AGENDAR --}}
                @if($horarioSeleccionado)
                    <div class="border-t border-gray-100 pt-8 mt-4 text-center animate-fade-in-up">
                        <button
                            wire:click="guardarCita"
                            wire:loading.attr="disabled"
                            class="
                                inline-flex items-center justify-center gap-2
                                bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                                text-white px-10 py-4 rounded-2xl font-bold text-xl 
                                shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 
                                transition-all transform hover:-translate-y-1 w-full sm:w-auto
                            "
                        >
                            <span>Confirmar Cita</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                @endif
            @endif

        </div>
    </div>
    
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</div>