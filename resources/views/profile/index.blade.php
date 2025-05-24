@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="heart-icon">My Profile</h1>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-3">
            <!-- Profile Sidebar -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="profile-avatar">
                            <img src="https://via.placeholder.com/150" alt="Profile Avatar" class="rounded-circle img-fluid">
                        </div>
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <div class="d-grid">
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#avatarModal">
                            <i class="fas fa-camera me-2"></i>Change Avatar
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Navigation</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('profile.index') }}" class="list-group-item list-group-item-action active">
                            <i class="fas fa-user me-2"></i>Profile Information
                        </a>
                        <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-shopping-bag me-2"></i>Order History
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-map-marker-alt me-2"></i>Addresses
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-credit-card me-2"></i>Payment Methods
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-heart me-2"></i>Wishlist
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-bell me-2"></i>Notifications
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-shield-alt fa-2x" style="color: var(--primary-color);"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Account Security</h5>
                            <p class="mb-0">Manage your security settings</p>
                        </div>
                    </div>
                    <div class="d-grid">
                        <a href="{{ route('profile.password') }}" class="btn btn-outline-primary">
                            <i class="fas fa-key me-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="birthdate" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate', $user->birthdate ?? '') }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $user->bio ?? '') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Default Address -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Default Address</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addressModal">
                        <i class="fas fa-edit me-1"></i>Edit
                    </button>
                </div>
                <div class="card-body">
                    @if(isset($user->address))
                        <address>
                            {{ $user->address->first_name }} {{ $user->address->last_name }}<br>
                            {{ $user->address->address_line1 }}<br>
                            @if($user->address->address_line2)
                                {{ $user->address->address_line2 }}<br>
                            @endif
                            {{ $user->address->city }}, {{ $user->address->state }} {{ $user->address->postal_code }}<br>
                            {{ $user->address->country }}
                        </address>
                    @else
                        <p class="mb-0">No default address set. <a href="#" data-bs-toggle="modal" data-bs-target="#addressModal">Add an address</a></p>
                    @endif
                </div>
            </div>
            
            <!-- Account Preferences -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Account Preferences</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.preferences') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Email Notifications</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="order_updates" name="preferences[order_updates]" {{ isset($user->preferences['order_updates']) && $user->preferences['order_updates'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="order_updates">
                                    Order updates and shipping notifications
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="promotions" name="preferences[promotions]" {{ isset($user->preferences['promotions']) && $user->preferences['promotions'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="promotions">
                                    Promotions and special offers
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="new_products" name="preferences[new_products]" {{ isset($user->preferences['new_products']) && $user->preferences['new_products'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="new_products">
                                    New product announcements
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="newsletter" name="preferences[newsletter]" {{ isset($user->preferences['newsletter']) && $user->preferences['newsletter'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="newsletter">
                                    Weekly newsletter
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Preferences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="avatarModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="avatar" class="form-label">Upload a new profile picture</label>
                        <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressModalLabel">Edit Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.address') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->address->first_name ?? '' }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->address->last_name ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address_line1" class="form-label">Address Line 1</label>
                        <input type="text" class="form-control" id="address_line1" name="address_line1" value="{{ $user->address->address_line1 ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address_line2" class="form-label">Address Line 2 (Optional)</label>
                        <input type="text" class="form-control" id="address_line2" name="address_line2" value="{{ $user->address->address_line2 ?? '' }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ $user->address->city ?? '' }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="state" class="form-label">State/Province</label>
                            <input type="text" class="form-control" id="state" name="state" value="{{ $user->address->state ?? '' }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" value="{{ $user->address->postal_code ?? '' }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select" id="country" name="country" required>
                            <option value="">Select Country</option>
                            <option value="US" {{ isset($user->address->country) && $user->address->country == 'US' ? 'selected' : '' }}>United States</option>
                            <option value="CA" {{ isset($user->address->country) && $user->address->country == 'CA' ? 'selected' : '' }}>Canada</option>
                            <option value="UK" {{ isset($user->address->country) && $user->address->country == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                            <option value="AU" {{ isset($user->address->country) && $user->address->country == 'AU' ? 'selected' : '' }}>Australia</option>
                            <option value="DE" {{ isset($user->address->country) && $user->address->country == 'DE' ? 'selected' : '' }}>Germany</option>
                            <option value="FR" {{ isset($user->address->country) && $user->address->country == 'FR' ? 'selected' : '' }}>France</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->address->phone ?? '' }}" required>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1" checked>
                        <label class="form-check-label" for="is_default">
                            Set as default address
                        </label>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto;
        overflow: hidden;
        border: 3px solid var(--primary-color);
        border-radius: 50%;
    }
    
    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endsection