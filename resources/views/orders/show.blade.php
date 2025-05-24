@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Order #{{ $order->id }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Order #{{ $order->id }}</h1>
                <div>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                    </a>
                </div>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3" style="width: 60px; height: 60px;">
                                                    @if($item->item && $item->item->image)
                                                        <img src="{{ asset('storage/' . $item->item->image) }}" alt="{{ $item->item->name }}" class="img-fluid rounded">
                                                    @else
                                                        <img src="https://via.placeholder.com/60x60?text=No+Image" alt="No Image" class="img-fluid rounded">
                                                    @endif
                                                </div>
                                                <div>
                                                    @if($item->item)
                                                        <a href="{{ route('items.show', $item->item->id) }}" class="text-decoration-none">{{ $item->item->name }}</a>
                                                    @else
                                                        {{ $item->name ?? 'Product no longer available' }}
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Shipping Address</h6>
                            <address>
                                {{ $order->first_name }} {{ $order->last_name }}<br>
                                {{ $order->address }}<br>
                                @if($order->address2)
                                    {{ $order->address2 }}<br>
                                @endif
                                {{ $order->city }}, {{ $order->state }} {{ $order->zip }}<br>
                                {{ $order->country }}
                            </address>
                        </div>
                        <div class="col-md-6">
                            <h6>Contact Information</h6>
                            <p>
                                <strong>Email:</strong> {{ $order->email }}<br>
                                <strong>Phone:</strong> {{ $order->phone }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Shipping Method</h6>
                            <p>
                                @if($order->shipping_method == 'standard')
                                    Standard Shipping (3-5 business days)
                                @elseif($order->shipping_method == 'express')
                                    Express Shipping (1-2 business days)
                                @elseif($order->shipping_method == 'overnight')
                                    Overnight Shipping (Next business day)
                                @else
                                    {{ ucfirst($order->shipping_method) }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Method</h6>
                            <p>
                                @if($order->payment_method == 'credit')
                                    Credit Card
                                @elseif($order->payment_method == 'paypal')
                                    PayPal
                                @elseif($order->payment_method == 'apple')
                                    Apple Pay
                                @else
                                    {{ ucfirst($order->payment_method) }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Notes -->
            @if($order->notes)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Notes</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Date:</span>
                        <span>{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Status:</span>
                        <span>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="badge bg-info">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="badge bg-primary">Shipped</span>
                            @elseif($order->status == 'delivered')
                                <span class="badge bg-success">Delivered</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </span>
                    </div>
                    
                    <div class="divider my-3"></div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span>${{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span>${{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="divider my-3"></div>
                    <div class="d-flex justify-content-between mb-3">
                        <h5>Total:</h5>
                        <h5>${{ number_format($order->total, 2) }}</h5>
                    </div>
                </div>
            </div>
            
            <!-- Order Timeline -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Order Placed</h6>
                                <small class="text-muted">{{ $order->created_at->format('M d, Y - h:i A') }}</small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker {{ $order->status != 'pending' ? 'bg-success' : 'bg-secondary' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Processing</h6>
                                <small class="text-muted">
                                    @if($order->status != 'pending')
                                        {{ $order->updated_at->format('M d, Y - h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker {{ $order->status == 'shipped' || $order->status == 'delivered' ? 'bg-success' : 'bg-secondary' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Shipped</h6>
                                <small class="text-muted">
                                    @if($order->status == 'shipped' || $order->status == 'delivered')
                                        {{ $order->updated_at->format('M d, Y - h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </small>
                            </div>
                        </div>
                        
                        <div class="timeline-item">
                            <div class="timeline-marker {{ $order->status == 'delivered' ? 'bg-success' : 'bg-secondary' }}"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Delivered</h6>
                                <small class="text-muted">
                                    @if($order->status == 'delivered')
                                        {{ $order->updated_at->format('M d, Y - h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Need Help? -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Need Help?</h5>
                </div>
                <div class="card-body">
                    <p>If you have any questions or issues with your order, please contact our customer support team.</p>
                    <div class="d-grid">
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-headset me-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    
    .timeline-item:last-child {
        padding-bottom: 0;
    }
    
    .timeline-marker {
        position: absolute;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        left: -30px;
        top: 5px;
    }
    
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: -23px;
        top: 20px;
        height: calc(100% - 15px);
        width: 2px;
        background-color: #e9ecef;
    }
</style>
@endsection