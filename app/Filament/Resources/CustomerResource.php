<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Process;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $pluralModelLabel = 'Clientes';
    protected static ?string $modelLabel = 'Cliente';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                $query->whereDoesntHave('processes')

                    ->orWhereHas('processes', function ($q) {
                        $q->whereIn('Estado', ['En Proceso', 'Decorado']);
                    });

            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Grid::make(2)
                    ->schema([

                        Section::make('Información del Cliente')
                            ->schema([
                                TextInput::make('Nombre')->disabled(),
                                TextInput::make('Telefono')->disabled(),
                                TextInput::make('Sexo')->disabled(),
                                TextInput::make('Tipo')->disabled(),
                                TextInput::make('EstadoCustomer')->disabled(),
                                TextInput::make('CodigoCustomer')->disabled(),
                            ])
                            ->columnSpan(1),

                        Section::make('Gestión del Proceso')
                            ->schema([

                                Select::make('EstadoProceso')
                                    ->label('Estado')
                                    ->options([
                                        'En Proceso' => 'En Proceso',
                                        'Decorado' => 'Decorado',
                                        'Entregado' => 'Entregado',
                                    ])
                                    ->required()
                                    ->afterStateHydrated(function ($set, $record) {
                                        $proceso = $record->processes->last();
                                        if ($proceso) {
                                            $set('EstadoProceso', $proceso->Estado);
                                        }
                                    }),

                                DatePicker::make('Fecha')
                                    ->required()
                                    ->afterStateHydrated(function ($set, $record) {
                                        $proceso = $record->processes->last();
                                        if ($proceso) {
                                            $set('Fecha', $proceso->Fecha);
                                        }
                                    }),

                                Textarea::make('Observacion')
                                    ->afterStateHydrated(function ($set, $record) {
                                        $proceso = $record->processes->last();
                                        if ($proceso) {
                                            $set('Observacion', $proceso->Observacion);
                                        }
                                    }),

                                Textarea::make('Historial')
                                    ->label('Historial')
                                    ->disabled()
                                    ->visible(fn ($record) => $record->processes->count() > 0)
                                    ->afterStateHydrated(function ($set, $record) {
                                        $proceso = $record->processes->last();
                                        if ($proceso) {
                                            $set('Historial', $proceso->Historial);
                                        }
                                    }),

                            ])
                            ->columnSpan(1),

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Nombre')
                    ->searchable(),

                TextColumn::make('Telefono'),

                TextColumn::make('Sexo'),

                TextColumn::make('Tipo')
                    ->badge()
                    ->color(fn ($state) => $state === 'Adulto' ? 'success' : 'warning'),

                TextColumn::make('EstadoCustomer')
                    ->label('Estado')
                    ->badge()
                    ->color(fn ($state) => $state === 'Pago' ? 'success' : 'danger'),

                TextColumn::make('CodigoCustomer')
                    ->label('Código')
                    ->copyable()
                    ->copyMessage('Código copiado'),
                TextColumn::make('processes.Estado')
                    ->label('Estado Proceso')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return $record->processes->last()?->Estado ?? 'Sin proceso';
                    })
                    ->color(fn ($state) =>
                        match ($state) {
                            'En Proceso' => 'warning',
                            'Decorado' => 'info',
                            default => 'gray',
                        }
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
