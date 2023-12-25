<?php

namespace App\Exports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsExport implements FromCollection, WithHeadings
{
    use Exportable;

    protected $selectedRows;

    public function __construct($selectedRows)
    {
        $this->selectedRows = $selectedRows;
    }

    public function collection()
    {
        // Fetch data based on selected rows
        $news = News::whereIn('id', $this->selectedRows)->get();

        // Transform the data if needed
        // Example: $news->map(function ($item) { return [...] });

        return $news;
    }

    public function headings(): array
    {
        // Define column headings
        return [
            'ID',
            'Nav Headings ID',
            'Nav Sub Headings ID',
            'Title',
            'Description',
            'Image',
            'Created At',
            'Updated At',
        ];
    }
}
