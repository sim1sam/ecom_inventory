<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportArrayExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    public function __construct(
        protected array $headingRow,
        protected array $rows,
        protected string $sheetTitle = 'Report'
    ) {
    }

    public function headings(): array
    {
        return $this->headingRow;
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return substr($this->sheetTitle, 0, 31);
    }
}
