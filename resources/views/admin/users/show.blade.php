@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>User Details: {{ $user->name }}</h1>
                <div>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Users
                    </a>
                </div>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <div class="row">
        <!-- User Information -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">User Information</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-container mx-auto mb-3" style="width: 120px; height: 120px;">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 120px; height: 120px; font-size: 48px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                        @if($user->isAdmin())
                            <span class="badge bg-danger">Administrator</span>
                        @else
                            <span class="badge bg-info">Visitor</span>
                        @endif
                    </div>
                    
                    <div class="divider mb-3"></div>
                    
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">User ID:</div>
                        <div class="col-7">{{ $user->id }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Registered:</div>
                        <div class="col-7">{{ $user->created_at->format('M d, Y') }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Status:</div>
                        <div class="col-7">
                            @if($user->active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Email Status:</div>
                        <div class="col-7">
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Unverified</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Phone:</div>
                        <div class="col-7">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Last Login:</div>
                        <div class="col-7">{{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit User
                        </a>
                        
                        @if(!$user->email_verified_at)
                            <form action="{{ route('admin.users.verify', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check-circle me-2"></i>Verify Email
                                </button>
                            </form>
                        @endif
                        
                        @if($user->active)
                            <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100" {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                    <i class="fas fa-ban me-2"></i>Deactivate Account
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.activate', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info w-100">
                                    <i class="fas fa-check me-2"></i>Activate Account
                                </button>
                            </form>
                        @endif
                        
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#passwordResetModal">
                            <i class="fas fa-key me-2"></i>Reset Password
                        </button>
                        
                        @if(auth()->id() != $user->id)
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>Delete User
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Orders and Activity -->
        <div class="col-md-8">
            <!-- Order History -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Order History</h5>
                    <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($orders) && count($orders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>
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
                                            </td>
                                            <td>{{ $order->orderItems->sum('quantity') }}</td>
                                            <td>${{ number_format($order->total, 2) }}</td>
                                            <td>
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">No orders found for this user.</p>
                    @endif
                </div>
            </div>
            
            <!-- Address Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Address Information</h5>
                </div>
                <div class="card-body">
                    @if(isset($user->address))
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Default Address</h6>
                                <address>
                                    {{ $user->address->first_name }} {{ $user->address->last_name }}<br>
                                    {{ $user->address->address_line1 }}<br>
                                    @if($user->address->address_line2)
                                        {{ $user->address->address_line2 }}<br>
                                    @endif
                                    {{ $user->address->city }}, {{ $user->address->state }} {{ $user->address->postal_code }}<br>
                                    {{ $user->address->country }}<br>
                                    <strong>Phone:</strong> {{ $user->address->phone }}
                                </address>
                            </div>
                            <div class="col-md-6">
                                <h6>Shipping Address</h6>
                                @if(isset($user->shipping_address))
                                    <address>
                                        {{ $user->shipping_address->first_name }} {{ $user->shipping_address->last_name }}<br>
                                        {{ $user->shipping_address->address_line1 }}<br>
                                        @if($user->shipping_address->address_line2)
                                            {{ $user->shipping_address->address_line2 }}<br>
                                        @endif
                                        {{ $user->shipping_address->city }}, {{ $user->shipping_address->state }} {{ $user->shipping_address->postal_code }}<br>
                                        {{ $user->shipping_address->country }}<br>
                                        <strong>Phone:</strong> {{ $user->shipping_address->phone }}
                                    </address>
                                @else
                                    <p>No shipping address provided.</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <p>No address information available.</p>
                    @endif
                </div>
            </div>
            
            <!-- Activity Log -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Activity Log</h5>
                </div>
                <div class="card-body">
                    @if(isset($activities) && count($activities) > 0)
                        <div class="timeline">
                            @foreach($activities as $activity)
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="mb-0">{{ $activity->description }}</h6>
                                            <small class="text-muted">{{ $activity->created_at->format('M d, Y H:i') }}</small>
                                        </div>
                                        @if($activity->properties)
                                            <small class="text-muted">{{ json_encode($activity->properties) }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center">No activity recorded for this user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Reset Modal -->
<div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordResetModalLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Choose an option to reset the password for <strong>{{ $user->name }}</strong>:</p>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="reset_type" id="reset_manual" value="manual" checked>
                        <label class="form-check-label" for="reset_manual">
                            Set a new password manually
                        </label>
                    </div>
                    
                    <div id="manual_password_fields">
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password" name="new_password">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password_confirmation')">
                                    <i class="fas fa-eye" id="new_password_confirmation_icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="reset_type" id="reset_auto" value="auto">
                        <label class="form-check-label" for="reset_auto">
                            Generate a random password
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="reset_type" id="reset_link" value="link">
                        <label class="form-check-label" for="reset_link">
                            Send password reset link to user's email
                        </label>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="notify_user" name="notify_user" value="1" checked>
                        <label class="form-check-label" for="notify_user">
                            Notify user by email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.</p>
                <p class="text-danger">Warning: This will also delete all associated data including orders, reviews, and other user-generated content.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
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

@section('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '_icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // Toggle password fields visibility based on reset type
    document.addEventListener('DOMContentLoaded', function() {
        const manualRadio = document.getElementById('reset_manual');
        const autoRadio = document.getElementById('reset_auto');
        const linkRadio = document.getElementById('reset_link');
        const manualFields = document.getElementById('manual_password_fields');
        
        function updateFieldsVisibility() {
            if (manualRadio.checked) {
                manualFields.style.display = 'block';
            } else {
                manualFields.style.display = 'none';
            }
        }
        
        manualRadio.addEventListener('change', updateFieldsVisibility);
        autoRadio.addEventListener('change', updateFieldsVisibility);
        linkRadio.addEventListener('change', updateFieldsVisibility);
        
        // Initial state
        updateFieldsVisibility();
    });
</script>
@endsection