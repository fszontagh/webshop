@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x" style="color: var(--success-color);"></i>
                    </div>
                    <h1 class="mb-3">Thank You for Your Order!</h1>
                    <p class="mb-4">Your order has been placed successfully. We've sent a confirmation email to {{ $order->email }}.</p>
                    
                    <div class="alert alert-info mb-4">
                        <h5>Order #{{ $order->id }}</h5>
                        <p class="mb-0">Please save this order number for your reference.</p>
                    </div>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-eye me-2"></i>View Order Details
                        </a>
                        <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-store me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Shipping Address</h5>
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
                            <div class="divider my-2"></div>
                            <div class="d-flex justify-content-between">
                                <h5>Total:</h5>
                                <h5>${{ number_format($order->total, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="mb-3">What Happens Next?</h5>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h6>Order Confirmation</h6>
                            <p class="mb-0">You will receive an email confirmation with your order details.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-box text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h6>Order Processing</h6>
                            <p class="mb-0">We'll prepare your items and get them ready for shipping.</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-shipping-fast text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h6>Shipping</h6>
                            <p class="mb-0">Your order will be shipped according to your selected shipping method.</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-home text-white"></i>
                            </div>
                        </div>
                        <div>
                            <h6>Delivery</h6>
                            <p class="mb-0">Your items will be delivered to your specified address.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection