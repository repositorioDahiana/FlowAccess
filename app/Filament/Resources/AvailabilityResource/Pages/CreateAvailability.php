<?php

namespace App\Filament\Resources\AvailabilityResource\Pages;

use Carbon\Carbon;
use App\Models\Availability;
use Filament\Notifications\Notification;
use App\Filament\Resources\AvailabilityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAvailability extends CreateRecord
{
    protected static string $resource = AvailabilityResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $fechaInicio = Carbon::parse($data['FechaInicio']);
        $fechaFin = Carbon::parse($data['FechaFin']);

        $horaInicio = Carbon::parse($data['HoraInicio']);
        $horaFin = Carbon::parse($data['HoraFin']);

        $intervalo = (int) $data['Intervalo'];

        $cantidadGenerada = 0;
        $ultimoRegistro = null;

        while ($fechaInicio->lte($fechaFin)) {

            $horaActual = $horaInicio->copy();

            while ($horaActual->lte($horaFin)) {

                $availability = Availability::firstOrCreate(
                    [
                        'AvailableDate' => $fechaInicio->format('Y-m-d'),
                        'AvailableTime' => $horaActual->format('H:i:s'),
                    ],
                    [
                        'Status' => false,
                    ]
                );

                if ($availability->wasRecentlyCreated) {
                    $cantidadGenerada++;
                    $ultimoRegistro = $availability;
                }

                $horaActual->addMinutes($intervalo);
            }

            $fechaInicio->addDay();
        }

        Notification::make()
            ->title('Disponibilidad generada')
            ->body("Se generaron {$cantidadGenerada} horarios correctamente.")
            ->success()
            ->send();

        // Filament necesita retornar un modelo.
        return $ultimoRegistro
            ?? Availability::query()->latest('IdAvailability')->first()
            ?? new Availability();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}