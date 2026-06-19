<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use App\Models\Process;
use Carbon\Carbon;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();

        $fechaActual = Carbon::now()->format('Y-m-d H:i');
        $estado = $data['EstadoProceso'];
        $obs = $data['Observacion'] ?? 'Sin observación';

        $nuevaLinea = "[{$fechaActual}] Estado: {$estado} | Obs: {$obs}";

        // 🔥 BUSCAR PROCESO EXISTENTE (UNO SOLO)
        $proceso = Process::where('IdCustomer', $this->record->IdCustomer)->first();

        if ($proceso) {

            // 🔹 Acumular historial
            $historial = $proceso->Historial
                ? $proceso->Historial . "\n" . $nuevaLinea
                : $nuevaLinea;

            // 🔥 ACTUALIZAR (NO CREAR)
            $proceso->update([
                'Estado' => $estado,
                'Fecha' => $data['Fecha'],
                'Observacion' => $obs,
                'Historial' => $historial,
            ]);

        } else {

            // 🔥 CREAR SOLO SI NO EXISTE
            Process::create([
                'IdCustomer' => $this->record->IdCustomer,
                'Estado' => $estado,
                'Fecha' => $data['Fecha'],
                'Observacion' => $obs,
                'Historial' => $nuevaLinea,
            ]);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}