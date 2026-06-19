<?php

namespace App\Filament\Resources\CustomerEntregaResource\Pages;

use App\Filament\Resources\CustomerEntregaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerEntregas extends ListRecords
{
    protected static string $resource = CustomerEntregaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
