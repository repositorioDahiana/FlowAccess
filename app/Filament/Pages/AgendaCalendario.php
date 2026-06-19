<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Availability;
use Carbon\Carbon;

class AgendaCalendario extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Calendario de Agenda';
    protected static ?string $title = 'Calendario de Disponibilidad';

    protected static string $view = 'filament.pages.agenda-calendario';

    public $currentMonth;
    public $currentYear;

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function prevMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function goToToday()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    protected function getViewData(): array
    {
        $startOfMonth = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        // Get availability for this month
        $availabilities = Availability::whereBetween('AvailableDate', [$startOfMonth->format('Y-m-d'), $endOfMonth->format('Y-m-d')])
            ->orderBy('AvailableTime')
            ->get();

        $daysInMonth = $startOfMonth->daysInMonth;
        // Day of week of the 1st (0 = Sunday, 1 = Monday ... 6 = Saturday)
        $firstDayOfWeek = $startOfMonth->dayOfWeek;

        // Group availabilities by day
        $availabilitiesByDay = [];
        foreach ($availabilities as $availability) {
            $day = Carbon::parse($availability->AvailableDate)->day;
            if (!isset($availabilitiesByDay[$day])) {
                $availabilitiesByDay[$day] = [];
            }
            $availabilitiesByDay[$day][] = $availability;
        }

        return [
            'monthName' => ucfirst($startOfMonth->translatedFormat('F Y')),
            'daysInMonth' => $daysInMonth,
            'firstDayOfWeek' => $firstDayOfWeek,
            'availabilitiesByDay' => $availabilitiesByDay,
        ];
    }
}
