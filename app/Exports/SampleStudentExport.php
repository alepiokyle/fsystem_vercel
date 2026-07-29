<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SampleStudentExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Student ID',
        ];
    }

    public function array(): array
    {
        return [
            ['2021001'],
            ['2021002'],
            ['2021003'],
        ];
    }
}
