<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-logo {
            max-width: 200px;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h1 {
            color: #ff6b9d;
            margin: 0;
            font-size: 28px;
        }
        
        .invoice-title p {
            margin: 5px 0;
        }
        
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .invoice-details-col {
            flex: 1;
        }
        
        .invoice-details-col h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 0;
        }
        
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .invoice-table th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }
        
        .invoice-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .invoice-table .text-right {
            text-align: right;
        }
        
        .invoice-totals {
            width: 300px;
            margin-left: auto;
        }
        
        .invoice-totals table {
            width: 100%;
        }
        
        .invoice-totals table td {
            padding: 5px 0;
        }
        
        .invoice-totals table td:last-child {
            text-align: right;
        }
        
        .invoice-totals .total-row {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #ddd;
        }
        
        .invoice-notes {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .invoice-footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            
            body {
                padding: 0;
                margin: 0;
            }
            
            .invoice-container {
                max-width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 8px 16px; background-color: #ff6b9d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Invoice
            </button>
            <a href="{{ route('admin.orders.show', $order->id) }}" style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 4px; text-decoration: none; margin-left: 10px;">
                Back to Order
            </a>
        </div>
        
        <div class="invoice-header">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Girly Shop Logo" class="invoice-logo">
            </div>
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <p>Invoice #: {{ $order->id }}</p>
                <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
                <p>Order Status: {{ ucfirst($order->status) }}</p>
            </div>
        </div>
        
        <div class="invoice-details">
            <div class="invoice-details-col">
                <h3>Bill To</h3>
                <p>
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                    {{ $order->email }}<br>
                    {{ $order->phone }}
                </p>
                <p>
                    {{ $order->address }}<br>
                    @if($order->address2)
                        {{ $order->address2 }}<br>
                    @endif
                    {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                    {{ $order->country }}
                </p>
            </div>
            <div class="invoice-details-col">
                <h3>Payment Information</h3>
                <p>
                    <strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}<br>
                    <strong>Payment Status:</strong> {{ ucfirst($order->payment_status ?? 'N/A') }}<br>
                    @if($order->transaction_id)
                        <strong>Transaction ID:</strong> {{ $order->transaction_id }}<br>
                    @endif
                    @if($order->paid_at)
                        <strong>Payment Date:</strong> {{ $order->paid_at->format('M d, Y') }}
                    @endif
                </p>
                <h3>Shipping Information</h3>
                <p>
                    <strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}<br>
                    @if($order->tracking_number)
                        <strong>Tracking Number:</strong> {{ $order->tracking_number }}
                    @endif
                </p>
            </div>
        </div>
        
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->item->name ?? 'Product' }}</td>
                        <td>
                            @if($item->item && $item->item->sku)
                                SKU: {{ $item->item->sku }}
                            @else
                                Product ID: {{ $item->item_id }}
                            @endif
                        </td>
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="invoice-totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Shipping:</td>
                    <td>${{ number_format($order->shipping, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td>${{ number_format($order->tax, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>Total:</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>
        
        @if($order->notes)
            <div class="invoice-notes">
                <h3>Notes</h3>
                <p>{{ $order->notes }}</p>
            </div>
        @endif
        
        <div class="invoice-footer">
            <p>Thank you for your business!</p>
            <p>If you have any questions about this invoice, please contact our customer support.</p>
            <p>{{ config('app.name') }} | {{ config('app.url') }}</p>
        </div>
    </div>
</body>
</html>