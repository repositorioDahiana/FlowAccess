<x-filament-panels::page>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 dark:bg-gray-900 dark:border-gray-800">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white capitalize">
                {{ $monthName }}
            </h2>
            <div class="flex items-center space-x-2">
                <button wire:click="prevMonth" class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                    &larr; Anterior
                </button>
                <button wire:click="goToToday" class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                    Hoy
                </button>
                <button wire:click="nextMonth" class="px-3 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700 transition">
                    Siguiente &rarr;
                </button>
            </div>
        </div>

        <!-- Calendar Grid -->
        <div class="p-4">
            <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Days of week -->
                @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $day)
                    <div class="bg-gray-50 dark:bg-gray-800 py-2 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                        {{ $day }}
                    </div>
                @endforeach

                <!-- Empty days for start of month -->
                @for($i = 0; $i < $firstDayOfWeek; $i++)
                    <div class="bg-white dark:bg-gray-900 min-h-[120px] p-2 border-t border-gray-100 dark:border-gray-800"></div>
                @endfor

                <!-- Days in month -->
                @for($day = 1; $day <= $daysInMonth; $day++)
                    <div class="bg-white dark:bg-gray-900 min-h-[120px] p-2 flex flex-col border-t border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <div class="flex justify-end">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 {{ ($day == now()->day && $currentMonth == now()->month && $currentYear == now()->year) ? 'bg-primary-600 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-sm' : 'w-7 h-7 flex items-center justify-center' }}">
                                {{ $day }}
                            </span>
                        </div>
                        
                        <div class="mt-2 flex-1 overflow-y-auto space-y-1">
                            @if(isset($availabilitiesByDay[$day]))
                                @foreach($availabilitiesByDay[$day] as $avail)
                                    @if($avail->Status == 0)
                                        <div class="text-xs px-2 py-1 rounded bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800 truncate shadow-sm" title="{{ \Carbon\Carbon::parse($avail->AvailableTime)->format('H:i') }} - Disponible">
                                            🟢 {{ \Carbon\Carbon::parse($avail->AvailableTime)->format('H:i') }}
                                        </div>
                                    @else
                                        @if($avail->appointments->isNotEmpty())
                                            <button wire:click="mountAction('updateAppointment', { appointmentId: {{ $avail->appointments->first()->IdAppointment }} })" type="button" class="w-full text-left text-xs px-2 py-1 rounded bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 truncate shadow-sm hover:bg-red-200 dark:hover:bg-red-800 transition cursor-pointer" title="{{ \Carbon\Carbon::parse($avail->AvailableTime)->format('H:i') }} - Agendada">
                                                🔴 {{ \Carbon\Carbon::parse($avail->AvailableTime)->format('H:i') }}
                                            </button>
                                        @else
                                            <div class="text-xs px-2 py-1 rounded bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800 truncate shadow-sm opacity-80" title="{{ \Carbon\Carbon::parse($avail->AvailableTime)->format('H:i') }} - Agendada">
                                                🔴 {{ \Carbon\Carbon::parse($avail->AvailableTime)->format('H:i') }}
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endfor
                
                <!-- Empty days for end of month -->
                @php
                    $totalCells = $firstDayOfWeek + $daysInMonth;
                    $remainingCells = $totalCells % 7 == 0 ? 0 : 7 - ($totalCells % 7);
                @endphp
                @for($i = 0; $i < $remainingCells; $i++)
                    <div class="bg-white dark:bg-gray-900 min-h-[120px] p-2 border-t border-gray-100 dark:border-gray-800"></div>
                @endfor
            </div>
        </div>
    </div>
</x-filament-panels::page>
