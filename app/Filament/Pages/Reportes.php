<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Process;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use App\Models\Customer;

class Reportes extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.reportes';
    protected static ?string $navigationLabel = 'Reportes';

    public $fechaInicio;
    public $fechaFin;
    public $estadoProceso;
    public $estadoCliente;
    public $resultados = [];

    public function buscar()
    {
        $query = Customer::with('processes');

        // 🔹 FILTRO ESTADO CLIENTE
        if ($this->estadoCliente) {
            $query->where('EstadoCustomer', $this->estadoCliente);
        }

        // 🔹 DETECTAR SI HAY FILTROS DE PROCESS
        $tieneFiltroProceso = $this->estadoProceso || $this->fechaInicio || $this->fechaFin;

        if ($tieneFiltroProceso) {

            // 👉 SOLO clientes que tengan process con filtros
            $query->whereHas('processes', function ($sub) {

                if ($this->estadoProceso) {
                    $sub->where('Estado', $this->estadoProceso);
                }

                if ($this->fechaInicio) {
                    $sub->whereDate('Fecha', '>=', $this->fechaInicio);
                }

                if ($this->fechaFin) {
                    $sub->whereDate('Fecha', '<=', $this->fechaFin);
                }

            });

        } else {

            // 👉 SIN filtros de process → traer TODOS
            $query->with('processes');

        }

        $this->resultados = $query->get();
    }

    // 📊 EXCEL (SIN CLASE EXTRA)
    public function exportExcel()
    {
        $data = collect($this->resultados)->map(function ($item) {

            $proceso = $item->processes->first();

            return [
                'Nombre' => $item->Nombre,
                'Telefono' => $item->Telefono,
                'Estado Cliente' => $item->EstadoCustomer,
                'Estado Proceso' => $proceso->Estado ?? 'Sin proceso',
                'Fecha' => $proceso->Fecha ?? '-',
            ];
        });

        return Excel::download(
            new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection {
                protected $data;

                public function __construct($data)
                {
                    $this->data = $data;
                }

                public function collection()
                {
                    return collect($this->data);
                }
            },
            'reporte.xlsx'
        );
    }

    // 📄 PDF (igual que antes)
    public function exportPdf()
    {
        $pdf = Pdf::loadView('pdf.report', [
            'data' => $this->resultados
        ]);

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'reporte.pdf'
        );
    }
}