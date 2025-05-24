<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packing Slip - Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .packing-slip-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .packing-slip-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .packing-slip-logo {
            max-width: 200px;
        }
        
        .packing-slip-title {
            text-align: right;
        }
        
        .packing-slip-title h1 {
            color: #ff6b9d;
            margin: 0;
            font-size: 28px;
        }
        
        .packing-slip-title p {
            margin: 5px 0;
        }
        
        .packing-slip-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .packing-slip-details-col {
            flex: 1;
        }
        
        .packing-slip-details-col h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-top: 0;
        }
        
        .packing-slip-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .packing-slip-table th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 10px;
            border-bottom: 2px solid #ddd;
        }
        
        .packing-slip-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .packing-slip-table .text-right {
            text-align: right;
        }
        
        .packing-slip-table .checkbox {
            width: 20px;
            height: 20px;
            border: 1px solid #ddd;
            display: inline-block;
            vertical-align: middle;
        }
        
        .packing-slip-notes {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        
        .packing-slip-footer {
            margin-top: 50px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
        
        .barcode {
            text-align: center;
            margin: 20px 0;
        }
        
        .barcode img {
            max-width: 300px;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            
            body {
                padding: 0;
                margin: 0;
            }
            
            .packing-slip-container {
                max-width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="packing-slip-container">
        <div class="no-print" style="text-align: right; margin-bottom: 20px;">
            <button onclick="window.print()" style="padding: 8px 16px; background-color: #ff6b9d; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Packing Slip
            </button>
            <a href="{{ route('admin.orders.show', $order->id) }}" style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 4px; text-decoration: none; margin-left: 10px;">
                Back to Order
            </a>
        </div>
        
        <div class="packing-slip-header">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Girly Shop Logo" class="packing-slip-logo">
            </div>
            <div class="packing-slip-title">
                <h1>PACKING SLIP</h1>
                <p>Order #: {{ $order->id }}</p>
                <p>Date: {{ $order->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        
        <div class="barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($order->id, 'C39+', 3, 50) }}" alt="Barcode">
        </div>
        
        <div class="packing-slip-details">
            <div class="packing-slip-details-col">
                <h3>Ship To</h3>
                <p>
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                    {{ $order->address }}<br>
                    @if($order->address2)
                        {{ $order->address2 }}<br>
                    @endif
                    {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                    {{ $order->country }}<br>
                    {{ $order->phone }}
                </p>
            </div>
            <div class="packing-slip-details-col">
                <h3>Order Information</h3>
                <p>
                    <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y') }}<br>
                    <strong>Shipping Method:</strong> {{ ucfirst($order->shipping_method) }}<br>
                    @if($order->tracking_number)
                        <strong>Tracking Number:</strong> {{ $order->tracking_number }}<br>
                    @endif
                    <strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}
                </p>
            </div>
        </div>
        
        <table class="packing-slip-table">
            <thead>
                <tr>
                    <th>Packed</th>
                    <th>SKU</th>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                    <tr>
                        <td><div class="checkbox"></div></td>
                        <td>{{ $item->item->sku ?? 'N/A' }}</td>
                        <td>{{ $item->item->name ?? 'Product ID: ' . $item->item_id }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->item->location ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($order->notes)
            <div class="packing-slip-notes">
                <h3>Order Notes</h3>
                <p>{{ $order->notes }}</p>
            </div>
        @endif
        
        <div class="packing-slip-notes">
            <h3>Packing Instructions</h3>
            <p>1. Please check each item as you pack it.</p>
            <p>2. Include any promotional materials or samples as applicable.</p>
            <p>3. Ensure all fragile items are properly wrapped and protected.</p>
            <p>4. Place this packing slip inside the package.</p>
        </div>
        
        <div class="packing-slip-footer">
            <p>Thank you for your business!</p>
            <p>{{ config('app.name') }} | {{ config('app.url') }}</p>
        </div>
    </div>
</body>
</html>