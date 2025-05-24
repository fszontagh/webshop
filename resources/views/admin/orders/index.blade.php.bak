@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Manage Orders</h1>
                <a href="{{ route('admin.orders.export') }}" class="btn btn-primary">
                    <i class="fas fa-file-export me-2"></i>Export Orders
                </a>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <!-- Search and Filters -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search orders..." name="search" value="{{ request('search') }}">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="status">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" placeholder="Date From">
                        </div>
                        <div class="col-md-2">
                            <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" placeholder="Date To">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="sort">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="total_asc" {{ request('sort') == 'total_asc' ? 'selected' : '' }}>Total: Low to High</option>
                                <option value="total_desc" {{ request('sort') == 'total_desc' ? 'selected' : '' }}>Total: High to Low</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Order Status Summary -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 mb-3 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <h6>All Orders</h6>
                                <h3>{{ $totalOrders ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <h6>Pending</h6>
                                <h3 class="text-warning">{{ $pendingOrders ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <h6>Processing</h6>
                                <h3 class="text-info">{{ $processingOrders ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <h6>Shipped</h6>
                                <h3 class="text-primary">{{ $shippedOrders ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <h6>Delivered</h6>
                                <h3 class="text-success">{{ $deliveredOrders ?? 0 }}</h3>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3 mb-md-0">
                            <div class="d-flex flex-column align-items-center">
                                <h6>Cancelled</h6>
                                <h3 class="text-danger">{{ $cancelledOrders ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                            <label class="form-check-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input order-checkbox" type="checkbox" id="order{{ $order->id }}" name="orders[]" value="{{ $order->id }}">
                                                <label class="form-check-label" for="order{{ $order->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.users.show', $order->user_id) }}">{{ $order->user->name }}</a>
                                        </td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'secondary')))) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->orderItems->sum('quantity') }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="processing">
                                                            <button type="submit" class="dropdown-item">Mark as Processing</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="shipped">
                                                            <button type="submit" class="dropdown-item">Mark as Shipped</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="delivered">
                                                            <button type="submit" class="dropdown-item">Mark as Delivered</button>
                                                        </form>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="dropdown-item text-danger">Cancel Order</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No orders found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bulk Actions -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Bulk Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.bulk-action') }}" method="POST" id="bulkActionForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <select class="form-select" name="action" id="bulkAction" required>
                                    <option value="">Select Action</option>
                                    <option value="mark_processing">Mark as Processing</option>
                                    <option value="mark_shipped">Mark as Shipped</option>
                                    <option value="mark_delivered">Mark as Delivered</option>
                                    <option value="mark_cancelled">Mark as Cancelled</option>
                                    <option value="export_selected">Export Selected</option>
                                    <option value="print_invoices">Print Invoices</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-warning w-100" id="applyBulkAction" disabled>Apply</button>
                            </div>
                            <div class="col-md-6 text-end">
                                <span id="selectedCount" class="me-3">0 orders selected</span>
                                <button type="button" class="btn btn-outline-secondary" id="clearSelection">Clear Selection</button>
                            </div>
                        </div>
                        
                        <div id="selectedOrdersContainer"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const orderCheckboxes = document.querySelectorAll('.order-checkbox');
        const selectedCountElement = document.getElementById('selectedCount');
        const applyBulkActionButton = document.getElementById('applyBulkAction');
        const clearSelectionButton = document.getElementById('clearSelection');
        const selectedOrdersContainer = document.getElementById('selectedOrdersContainer');
        const bulkActionForm = document.getElementById('bulkActionForm');
        
        // Select all functionality
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
            
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            
            updateSelectedCount();
        });
        
        // Individual checkbox change
        orderCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateSelectedCount();
                
                // Update "select all" checkbox state
                if (!this.checked) {
                    selectAllCheckbox.checked = false;
                } else {
                    const allChecked = Array.from(orderCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });
        
        // Clear selection button
        clearSelectionButton.addEventListener('click', function() {
            selectAllCheckbox.checked = false;
            
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            updateSelectedCount();
        });
        
        // Update selected count and button state
        function updateSelectedCount() {
            const selectedCheckboxes = document.querySelectorAll('.order-checkbox:checked');
            const count = selectedCheckboxes.length;
            
            selectedCountElement.textContent = count + ' order' + (count !== 1 ? 's' : '') + ' selected';
            applyBulkActionButton.disabled = count === 0;
            
            // Update hidden inputs for selected orders
            selectedOrdersContainer.innerHTML = '';
            
            selectedCheckboxes.forEach(checkbox => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_orders[]';
                input.value = checkbox.value;
                selectedOrdersContainer.appendChild(input);
            });
        }
        
        // Form submission confirmation
        bulkActionForm.addEventListener('submit', function(e) {
            const action = document.getElementById('bulkAction').value;
            
            if (action === 'mark_cancelled') {
                if (!confirm('Are you sure you want to cancel the selected orders? This action cannot be undone.')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>
@endsection