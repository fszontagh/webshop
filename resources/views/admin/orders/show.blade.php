@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Order #{{ $order->id }}</h1>
                <div>
                    <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-info me-2" target="_blank">
                        <i class="fas fa-file-invoice me-2"></i>Invoice
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                    </a>
                </div>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <!-- Order Status -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning p-2"><i class="fas fa-clock fa-lg"></i></span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-info p-2"><i class="fas fa-cog fa-lg"></i></span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge bg-primary p-2"><i class="fas fa-shipping-fast fa-lg"></i></span>
                                    @elseif($order->status == 'delivered')
                                        <span class="badge bg-success p-2"><i class="fas fa-check-circle fa-lg"></i></span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="badge bg-danger p-2"><i class="fas fa-times-circle fa-lg"></i></span>
                                    @else
                                        <span class="badge bg-secondary p-2"><i class="fas fa-question-circle fa-lg"></i></span>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="mb-0">Status: <span class="text-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'secondary')))) }}">{{ ucfirst($order->status) }}</span></h5>
                                    <p class="mb-0 text-muted">Last Updated: {{ $order->updated_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-flex justify-content-end">
                                @csrf
                                @method('PUT')
                                <select class="form-select me-2" name="status" style="max-width: 200px;">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-primary">Update Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Order Details -->
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
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                            <i class="fas fa-box text-secondary"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    @if($item->item)
                                                        <a href="{{ route('admin.items.show', $item->item->id) }}">{{ $item->item->name }}</a>
                                                    @else
                                                        {{ $item->name ?? 'Product no longer available' }}
                                                    @endif
                                                    @if($item->item && $item->item->sku)
                                                        <br><small class="text-muted">SKU: {{ $item->item->sku }}</small>
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
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                    <td class="text-end">${{ number_format($order->shipping, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                    <td class="text-end">${{ number_format($order->tax, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                    <td class="text-end"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Customer Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Customer Details</h6>
                            <p>
                                <strong>Name:</strong> <a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->name }}</a><br>
                                <strong>Email:</strong> {{ $order->email }}<br>
                                <strong>Phone:</strong> {{ $order->phone }}<br>
                                <strong>Customer Since:</strong> {{ $order->user->created_at->format('M d, Y') }}<br>
                                <strong>Total Orders:</strong> {{ $customerOrderCount ?? 1 }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Information</h6>
                            <p>
                                <strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}<br>
                                <strong>Payment Status:</strong> 
                                @if($order->payment_status == 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($order->payment_status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->payment_status == 'failed')
                                    <span class="badge bg-danger">Failed</span>
                                @elseif($order->payment_status == 'refunded')
                                    <span class="badge bg-info">Refunded</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                                @endif
                                <br>
                                <strong>Transaction ID:</strong> {{ $order->transaction_id ?? 'N/A' }}<br>
                                <strong>Payment Date:</strong> {{ $order->paid_at ? $order->paid_at->format('M d, Y H:i') : 'N/A' }}
                            </p>
                        </div>
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
                            <h6>Shipping Details</h6>
                            <p>
                                <strong>Shipping Method:</strong> 
                                @if($order->shipping_method == 'standard')
                                    Standard Shipping (3-5 business days)
                                @elseif($order->shipping_method == 'express')
                                    Express Shipping (1-2 business days)
                                @elseif($order->shipping_method == 'overnight')
                                    Overnight Shipping (Next business day)
                                @else
                                    {{ ucfirst($order->shipping_method) }}
                                @endif
                                <br>
                                <strong>Tracking Number:</strong> 
                                @if($order->tracking_number)
                                    {{ $order->tracking_number }}
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                                <br>
                                <strong>Shipped Date:</strong> 
                                @if($order->shipped_at)
                                    {{ $order->shipped_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted">Not shipped yet</span>
                                @endif
                                <br>
                                <strong>Estimated Delivery:</strong> 
                                @if($order->estimated_delivery)
                                    {{ $order->estimated_delivery->format('M d, Y') }}
                                @else
                                    <span class="text-muted">Not available</span>
                                @endif
                            </p>
                            
                            @if($order->status == 'processing' || $order->status == 'shipped')
                                <form action="{{ route('admin.orders.update-tracking', $order->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="tracking_number" placeholder="Enter tracking number" value="{{ $order->tracking_number }}">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Notes -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order Notes</h5>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="fas fa-plus me-1"></i>Add Note
                    </button>
                </div>
                <div class="card-body">
                    @if(isset($orderNotes) && count($orderNotes) > 0)
                        <div class="timeline">
                            @foreach($orderNotes as $note)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-{{ $note->is_customer_visible ? 'info' : 'secondary' }}"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">{{ $note->title }}</h6>
                                            <small class="text-muted">{{ $note->created_at->format('M d, Y H:i') }}</small>
                                        </div>
                                        <p class="mb-1">{{ $note->content }}</p>
                                        <small class="text-muted">By: {{ $note->user->name }} 
                                            @if($note->is_customer_visible)
                                                <span class="badge bg-info ms-2">Customer Visible</span>
                                            @else
                                                <span class="badge bg-secondary ms-2">Admin Only</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No notes for this order.</p>
                    @endif
                    
                    @if($order->notes)
                        <div class="mt-3 p-3 bg-light rounded">
                            <h6>Customer Notes:</h6>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Order Summary and Actions -->
        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Date:</span>
                        <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Status:</span>
                        <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'secondary')))) }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Payment Status:</span>
                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : ($order->payment_status == 'failed' ? 'danger' : ($order->payment_status == 'refunded' ? 'info' : 'secondary'))) }}">
                            {{ ucfirst($order->payment_status ?? 'N/A') }}
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
                                        {{ $order->processing_at ? $order->processing_at->format('M d, Y - h:i A') : $order->updated_at->format('M d, Y - h:i A') }}
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
                                        {{ $order->shipped_at ? $order->shipped_at->format('M d, Y - h:i A') : $order->updated_at->format('M d, Y - h:i A') }}
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
                                        {{ $order->delivered_at ? $order->delivered_at->format('M d, Y - h:i A') : $order->updated_at->format('M d, Y - h:i A') }}
                                    @else
                                        Pending
                                    @endif
                                </small>
                            </div>
                        </div>
                        
                        @if($order->status == 'cancelled')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-0">Cancelled</h6>
                                    <small class="text-muted">
                                        {{ $order->cancelled_at ? $order->cancelled_at->format('M d, Y - h:i A') : $order->updated_at->format('M d, Y - h:i A') }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Order Actions -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-info" target="_blank">
                            <i class="fas fa-file-invoice me-2"></i>View Invoice
                        </a>
                        
                        <a href="{{ route('admin.orders.print-packing-slip', $order->id) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-print me-2"></i>Print Packing Slip
                        </a>
                        
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#emailCustomerModal">
                            <i class="fas fa-envelope me-2"></i>Email Customer
                        </button>
                        
                        @if($order->status != 'cancelled')
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                <i class="fas fa-times-circle me-2"></i>Cancel Order
                            </button>
                        @endif
                        
                        @if($order->payment_status == 'paid' && $order->status != 'refunded')
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#refundModal">
                                <i class="fas fa-undo me-2"></i>Process Refund
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Add Order Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.add-note', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="note_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="note_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="note_content" class="form-label">Content</label>
                        <textarea class="form-control" id="note_content" name="content" rows="3" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_customer_visible" name="is_customer_visible" value="1">
                        <label class="form-check-label" for="is_customer_visible">
                            Visible to customer
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Email Customer Modal -->
<div class="modal fade" id="emailCustomerModal" tabindex="-1" aria-labelledby="emailCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailCustomerModalLabel">Email Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.email-customer', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="email_subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="email_subject" name="subject" value="Your Order #{{ $order->id }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_message" class="form-label">Message</label>
                        <textarea class="form-control" id="email_message" name="message" rows="5" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="include_order_details" name="include_order_details" value="1" checked>
                        <label class="form-check-label" for="include_order_details">
                            Include order details
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Order Modal -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="cancelled">
                <div class="modal-body">
                    <p>Are you sure you want to cancel this order? This action cannot be undone.</p>
                    <div class="mb-3">
                        <label for="cancel_reason" class="form-label">Reason for Cancellation</label>
                        <select class="form-select" id="cancel_reason" name="cancel_reason" required>
                            <option value="">Select a reason</option>
                            <option value="customer_request">Customer Request</option>
                            <option value="out_of_stock">Out of Stock</option>
                            <option value="payment_issue">Payment Issue</option>
                            <option value="fraud_suspicious">Fraud/Suspicious Activity</option>
                            <option value="duplicate_order">Duplicate Order</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cancel_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="cancel_notes" name="cancel_notes" rows="3"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notify_customer_cancel" name="notify_customer" value="1" checked>
                        <label class="form-check-label" for="notify_customer_cancel">
                            Notify customer about cancellation
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Cancel Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundModalLabel">Process Refund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.orders.refund', $order->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="refund_amount" class="form-label">Refund Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" id="refund_amount" name="refund_amount" value="{{ $order->total }}" max="{{ $order->total }}" required>
                        </div>
                        <div class="form-text">Maximum refund amount: ${{ number_format($order->total, 2) }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="refund_reason" class="form-label">Reason for Refund</label>
                        <select class="form-select" id="refund_reason" name="refund_reason" required>
                            <option value="">Select a reason</option>
                            <option value="customer_request">Customer Request</option>
                            <option value="product_defective">Product Defective</option>
                            <option value="wrong_item">Wrong Item Shipped</option>
                            <option value="arrived_late">Arrived Too Late</option>
                            <option value="not_as_described">Item Not As Described</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="refund_notes" class="form-label">Additional Notes</label>
                        <textarea class="form-control" id="refund_notes" name="refund_notes" rows="3"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notify_customer_refund" name="notify_customer" value="1" checked>
                        <label class="form-check-label" for="notify_customer_refund">
                            Notify customer about refund
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Process Refund</button>
                </div>
            </form>
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