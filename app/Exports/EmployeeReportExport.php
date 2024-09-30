<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EmployeeReportExport implements FromCollection, WithHeadings
{
    protected $report;

    public function __construct($report)
    {
        $this->report = $report;
    }

    public function collection()
    {
        return new Collection($this->report);
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Horas disponibles',
            'Horas reservadas'
        ];
    }
}
