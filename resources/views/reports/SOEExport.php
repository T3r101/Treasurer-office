<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SOEExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(protected $collection) {}

    public function collection() { return $this->collection; }

    public function headings(): array
    {
        return ['Date', 'Check No', 'Payee', 'Nature of Payment', 'Account Code', 'Amount'];
    }

    public function map($item): array
    {
        return [
            \Carbon\Carbon::parse($item->transaction_date)->format('Y-m-d'),
            $item->check_no,
            $item->payee,
            $item->nature_of_payment,
            $item->account_code,
            $item->amount_issued > 0 ? $item->amount_issued : $item->amount,
        ];
    }
}