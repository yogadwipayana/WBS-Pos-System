<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class TransactionExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Transaction::query()->with('order');

        // Filter by payment method
        if ($this->request->filled('payment_method')) {
            $query->where('payment_method', $this->request->payment_method);
        }

        // Filter by payment status
        if ($this->request->filled('payment_status')) {
            $query->where('payment_status', $this->request->payment_status);
        }

        // Filter by date range
        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }
        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }

        // Filter by amount range
        if ($this->request->filled('amount_min')) {
            $query->where('amount', '>=', $this->request->amount_min);
        }
        if ($this->request->filled('amount_max')) {
            $query->where('amount', '<=', $this->request->amount_max);
        }

        // Search by transaction number or order number
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_number', 'like', "%{$search}%")
                    ->orWhereHas('order', function ($q) use ($search) {
                        $q->where('order_number', 'like', "%{$search}%");
                    });
            });
        }

        // Adjust ordering if needed, but usually export follows a logical order
        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Transaction Number',
            'Order Number',
            'Customer Name',
            'Payment Method',
            'Amount (Rp)',
            'Status',
            'Date',
            'Notes',
        ];
    }

    public function map($transaction): array
    {
        return [
            $transaction->transaction_number,
            $transaction->order ? $transaction->order->order_number : 'N/A',
            $transaction->order ? $transaction->order->customer_name : 'N/A',
            ucfirst($transaction->payment_method),
            $transaction->amount,
            ucfirst($transaction->payment_status),
            $transaction->created_at->format('d/m/Y H:i:s'),
            $transaction->notes,
        ];
    }
}
