@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Product Details: {{ $item->name }}</h1>
                <div>
                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.items.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <div class="row">
        <!-- Product Images -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid rounded">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                                <i class="fas fa-image fa-5x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                    
                    @if(isset($item->gallery_images) && is_array($item->gallery_images) && count($item->gallery_images) > 0)
                        <h5 class="mb-3">Gallery Images</h5>
                        <div class="row g-2">
                            @foreach($item->gallery_images as $image)
                                <div class="col-4">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-fluid rounded">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Product Information -->
        <div class="col-md-7 mb-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Product Name:</div>
                        <div class="col-md-9">{{ $item->name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Category:</div>
                        <div class="col-md-9">{{ ucfirst($item->category ?? 'Uncategorized') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Price:</div>
                        <div class="col-md-9">
                            @if(isset($item->sale_price) && $item->sale_price < $item->price)
                                <span class="text-decoration-line-through text-muted me-2">${{ number_format($item->price, 2) }}</span>
                                <span class="text-danger">${{ number_format($item->sale_price, 2) }}</span>
                            @else
                                ${{ number_format($item->price, 2) }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Stock:</div>
                        <div class="col-md-9">
                            @if(isset($item->stock) && $item->stock > 0)
                                <span class="badge bg-success">In Stock ({{ $item->stock }})</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">SKU:</div>
                        <div class="col-md-9">{{ $item->sku ?? 'N/A' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            @if($item->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($item->status == 'draft')
                                <span class="badge bg-warning">Draft</span>
                            @elseif($item->status == 'archived')
                                <span class="badge bg-secondary">Archived</span>
                            @else
                                <span class="badge bg-info">{{ ucfirst($item->status) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Visibility:</div>
                        <div class="col-md-9">
                            @if($item->visibility == 'public')
                                <span class="badge bg-info">Public</span>
                            @else
                                <span class="badge bg-secondary">Private</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Featured:</div>
                        <div class="col-md-9">
                            @if($item->featured)
                                <span class="badge bg-primary">Featured</span>
                            @else
                                <span class="badge bg-secondary">Not Featured</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created:</div>
                        <div class="col-md-9">{{ $item->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 fw-bold">Last Updated:</div>
                        <div class="col-md-9">{{ $item->updated_at->format('M d, Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    {!! nl2br(e($item->description)) !!}
                </div>
            </div>
            
            @if($item->specifications)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Specifications</h5>
                    </div>
                    <div class="card-body">
                        {!! nl2br(e($item->specifications)) !!}
                    </div>
                </div>
            @endif
            
            @if($item->tags)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Tags</h5>
                    </div>
                    <div class="card-body">
                        @foreach(explode(',', $item->tags) as $tag)
                            <span class="badge bg-secondary me-1">{{ trim($tag) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <!-- Sales Statistics -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Sales Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Total Sales</h6>
                                    <h3 class="mb-0">{{ $item->total_sales ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Revenue</h6>
                                    <h3 class="mb-0">${{ number_format($item->total_revenue ?? 0, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Views</h6>
                                    <h3 class="mb-0">{{ $item->views ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6 class="card-title">Conversion Rate</h6>
                                    <h3 class="mb-0">
                                        @if(isset($item->views) && $item->views > 0 && isset($item->total_sales))
                                            {{ number_format(($item->total_sales / $item->views) * 100, 2) }}%
                                        @else
                                            0%
                                        @endif
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Orders -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Recent Orders</h5>
                </div>
                <div class="card-body">
                    @if(isset($recentOrders) && count($recentOrders) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Quantity</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>{{ $order->quantity }}</td>
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
                        <p class="text-center">No orders found for this product.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Actions -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-edit me-2"></i>Edit Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('items.show', $item->id) }}" class="btn btn-info w-100" target="_blank">
                                <i class="fas fa-eye me-2"></i>View in Store
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#duplicateModal">
                                <i class="fas fa-copy me-2"></i>Duplicate
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
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
                Are you sure you want to delete <strong>{{ $item->name }}</strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Duplicate Modal -->
<div class="modal fade" id="duplicateModal" tabindex="-1" aria-labelledby="duplicateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="duplicateModalLabel">Duplicate Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.items.duplicate', $item->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Create a duplicate copy of <strong>{{ $item->name }}</strong>.</p>
                    <div class="mb-3">
                        <label for="duplicate_name" class="form-label">New Product Name</label>
                        <input type="text" class="form-control" id="duplicate_name" name="duplicate_name" value="{{ $item->name }} (Copy)" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="duplicate_images" name="duplicate_images" value="1" checked>
                        <label class="form-check-label" for="duplicate_images">
                            Include images
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Duplicate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection