<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return DB::table('books as b')
            ->join('publisher as p', 'b.id_publisher', '=', 'p.id')
            ->join('books_authors as ab', 'b.id', '=', 'ab.id_books')
            ->join('authors as au', 'au.id', '=', 'ab.id_authors')
            ->select(
                'b.id',
                'b.name',
                'b.ISBN',
                'b.price',
                'b.Bibliography',
                'p.name as publisher_name',
                DB::raw('GROUP_CONCAT(au.name SEPARATOR ", ") as authors')
            )
            ->groupBy(
                'b.id',
                'b.name',
                'b.ISBN',
                'b.price',
                'b.Bibliography',
                'p.name'
            )
            ->orderBy('b.id')
            ->get();

    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'ISBN',
            'Price',
            'Bibliography',
            'Publisher Name',
            'Authors'
        ];
    }
}