<?php

namespace App\Exports;

use App\Models\Publisher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Excel;

class PublisherExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection

    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'Publisher.xlsx';

    /**
     * Optional Writer Type
     */
    private $writerType = Excel::XLSX;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function collection()
    {
        return Publisher::select('id', 'name')->get();
    }

    public function headings(): array
    {
        return ["ID", "Name"];
    }
}
