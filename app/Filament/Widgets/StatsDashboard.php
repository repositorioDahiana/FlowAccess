<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Process;
use App\Models\Customer;

class StatsDashboard extends BaseWidget
{
    protected function getCards(): array
    {
        return [

            // 🔹 PROCESS
            Card::make('En Proceso', Process::where('Estado', 'En Proceso')->count())
                ->description('Procesos activos')
                ->color('warning')
                ->icon('heroicon-o-clock'),

            Card::make('Decorado', Process::where('Estado', 'Decorado')->count())
                ->description('Procesos decorados')
                ->color('info')
                ->icon('heroicon-o-paint-brush'),

            Card::make('Entregado', Process::where('Estado', 'Entregado')->count())
                ->description('Procesos finalizados')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            // 🔹 CUSTOMER
            Card::make('Clientes en Deuda', Customer::where('EstadoCustomer', 'Debe')->count())
                ->description('Pendientes de pago')
                ->color('danger')
                ->icon('heroicon-o-x-circle'),

            Card::make('Clientes al Día', Customer::where('EstadoCustomer', 'Pago')->count())
                ->description('Pagos completos')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

        ];
    }
}