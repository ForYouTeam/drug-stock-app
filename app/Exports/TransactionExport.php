<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transactions;

    public function __construct($transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Total In',
            'Total Out',
            'Created At',
        ];
    }
    public function map($transactions): array
    {
        $no = 1;
        return [
            $no++,
            $transactions->receiver->nama,
            $transactions->total_in,
            $transactions->total_out,
            $transactions->created_at,
        ];
    }
}
