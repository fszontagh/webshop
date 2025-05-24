<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function collection()
    {
        return Order::with('user')->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Customer Name',
            'Customer Email',
            'Date',
            'Status',
            'Total',
            'Items'
        ];
    }

    public function map($order): array
    {
        $items = $order->orderItems->map(function($item) {
            return "{$item->quantity}x {$item->item->name} (\${" . number_format($item->price, 2) . "})";
        })->implode(', ');

        return [
            $order->id,
            $order->user->name,
            $order->user->email,
            $order->created_at->format('Y-m-d H:i:s'),
            ucfirst($order->status),
            number_format($order->total, 2),
            $items
        ];
    }
}