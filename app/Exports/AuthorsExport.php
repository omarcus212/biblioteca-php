<?php

namespace App\Exports;

use App\Models\Authors;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuthorsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Authors::select('id', 'name')->get();
    }
    public function headings(): array
    {
        return ["ID", "Name"];
    }
}
