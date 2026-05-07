<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CDRExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected $collection) {}

    public function collection() { return $this->collection; }

    public function headings(): array
    {
        return ['Date', 'Check No', 'Payee', 'Nature of Payment', 'Amount'];
    }

    public function map($item): array
    {
        return [
            \Carbon\Carbon::parse($item->deposit_date)->format('Y-m-d'),
            $item->cheque_number,
            $item->payee,
            $item->nature_of_payment,
            $item->amount,
        ];
    }
}