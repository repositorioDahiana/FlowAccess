<?php

namespace App\Filament\Resources\CustomerEntregaResource\Pages;

use App\Filament\Resources\CustomerEntregaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerEntrega extends EditRecord
{
    protected static string $resource = CustomerEntregaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
