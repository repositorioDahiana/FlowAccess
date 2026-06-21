<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Appointment;
use App\Models\Availability;

class PublicAppointment extends Component
{
    public $codigo;
    public $customer;
    public $fechaSeleccionada;
    public $horarioSeleccionado;
    public $mostrarAgenda = false;

    public function validarCodigo()
    {
        $this->customer = Customer::where(
            'CodigoCustomer',
            $this->codigo
        )->first();

        if (!$this->customer) {

            $this->addError(
                'codigo',
                'Código no encontrado.'
            );

            return;
        }

        $hasActiveOrFinishedAppointment = Appointment::where('IdCustomer', $this->customer->IdCustomer)
            ->where(function ($query) {
                // Bloquear si el EstadoAgen es nulo (cita futura/pendiente) o si es "Asistio"
                $query->whereNull('EstadoAgen')
                      ->orWhere('EstadoAgen', '!=', 'No asistio');
            })
            ->exists();

        if ($hasActiveOrFinishedAppointment) {
            $this->addError('codigo', 'Ya tienes una cita activa o ya has asistido a una anteriormente.');
            return;
        }

        $this->mostrarAgenda = true;
    }

    public function guardarCita()
    {
        $availability = Availability::find(
            $this->horarioSeleccionado
        );

        if (!$availability || $availability->Status == 1) {

            $this->addError(
                'horario',
                'Horario no disponible.'
            );

            return;
        }

        Appointment::create([
            'IdCustomer' => $this->customer->IdCustomer,
            'IdAvailability' => $availability->IdAvailability,
            'Status' => 'Agendada',
            'Notes' => null,
        ]);

        $availability->update([
            'Status' => 1,
        ]);

        session()->flash(
            'success',
            'Cita agendada correctamente.'
        );

        $this->reset();
    }

    public function render()
    {
        $fechas = Availability::where('Status', 0)
            ->select('AvailableDate')
            ->distinct()
            ->orderBy('AvailableDate')
            ->get();

        $horarios = [];

        if ($this->fechaSeleccionada) {

            $horarios = Availability::where(
                'AvailableDate',
                $this->fechaSeleccionada
            )
            ->where('Status', 0)
            ->orderBy('AvailableTime')
            ->get();
        }

        return view('livewire.public-appointment', [
            'fechas' => $fechas,
            'horarios' => $horarios,
        ])
        ->layout('appointment');
    }
}