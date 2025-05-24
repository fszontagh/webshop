@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar / Filters -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('items.index') }}" class="list-group-item list-group-item-action {{ !request('category') ? 'active' : '' }}">
                            All Items
                        </a>
                        <a href="{{ route('items.index', ['category' => 'fashion']) }}" class="list-group-item list-group-item-action {{ request('category') == 'fashion' ? 'active' : '' }}">
                            <i class="fas fa-tshirt me-2"></i>Fashion
                        </a>
                        <a href="{{ route('items.index', ['category' => 'beauty']) }}" class="list-group-item list-group-item-action {{ request('category') == 'beauty' ? 'active' : '' }}">
                            <i class="fas fa-magic me-2"></i>Beauty
                        </a>
                        <a href="{{ route('items.index', ['category' => 'tech']) }}" class="list-group-item list-group-item-action {{ request('category') == 'tech' ? 'active' : '' }}">
                            <i class="fas fa-headphones me-2"></i>Tech
                        </a>
                        <a href="{{ route('items.index', ['category' => 'accessories']) }}" class="list-group-item list-group-item-action {{ request('category') == 'accessories' ? 'active' : '' }}">
                            <i class="fas fa-gem me-2"></i>Accessories
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Price Range</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.index') }}" method="GET">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <div class="mb-3">
                            <label for="min_price" class="form-label">Min Price</label>
                            <input type="number" class="form-control" id="min_price" name="min_price" value="{{ request('min_price') }}" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="max_price" class="form-label">Max Price</label>
                            <input type="number" class="form-control" id="max_price" name="max_price" value="{{ request('max_price') }}" min="0">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <!-- Items Grid -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="heart-icon">
                    @if(request('category'))
                        {{ ucfirst(request('category')) }} Items
                    @else
                        All Items
                    @endif
                </h2>
                <div class="d-flex align-items-center">
                    <label for="sort" class="me-2">Sort by:</label>
                    <select id="sort" class="form-select" onchange="window.location.href=this.value">
                        <option value="{{ route('items.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                            Newest
                        </option>
                        <option value="{{ route('items.index', array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="{{ route('items.index', array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                        <option value="{{ route('items.index', array_merge(request()->except('sort'), ['sort' => 'name_asc'])) }}" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                            Name: A to Z
                        </option>
                    </select>
                </div>
            </div>
            
            <div class="divider mb-4"></div>
            
            @if($items->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No items found matching your criteria.
                </div>
            @else
                <div class="row">
                    @foreach($items as $item)
                        <div class="col-md-4 mb-4">
                            <div class="item-card">
                                <a href="{{ route('items.show', $item->id) }}">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                                    @else
                                        <img src="https://via.placeholder.com/300x300?text=No+Image" alt="No Image">
                                    @endif
                                </a>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text">{{ Str::limit($item->description, 50) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="price">${{ number_format($item->price, 2) }}</span>
                                        <div>
                                            <a href="{{ route('items.show', $item->id) }}" class="btn btn-sm btn-primary me-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-cart-plus"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $items->appends(request()->except('page'))->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection