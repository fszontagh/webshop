@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="heart-icon">Your Shopping Cart</h1>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3" style="width: 80px; height: 80px;">
                                                        @if($item['image'])
                                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid rounded">
                                                        @else
                                                            <img src="https://via.placeholder.com/80x80?text=No+Image" alt="No Image" class="img-fluid rounded">
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h5 class="mb-0">
                                                            <a href="{{ route('items.show', $item['id']) }}" class="text-decoration-none">{{ $item['name'] }}</a>
                                                        </h5>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>${{ number_format($item['price'], 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.update') }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="decrementQuantity(this)">-</button>
                                                        <input type="number" name="quantity" class="form-control text-center quantity-input" value="{{ $item['quantity'] }}" min="1">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="incrementQuantity(this)">+</button>
                                                    </div>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>${{ number_format($item['subtotal'], 2) }}</td>
                                            <td>
                                                <form action="{{ route('cart.remove') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('items.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash me-2"></i>Clear Cart
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>{{ $total >= 50 ? 'Free' : '$5.99' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Tax (10%):</span>
                            <span>${{ number_format($total * 0.1, 2) }}</span>
                        </div>
                        <div class="divider my-3"></div>
                        <div class="d-flex justify-content-between mb-3">
                            <h5>Total:</h5>
                            <h5>${{ number_format($total + ($total >= 50 ? 0 : 5.99) + ($total * 0.1), 2) }}</h5>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100">
                            <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                        </a>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Have a Coupon?</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Coupon code">
                                <button class="btn btn-outline-primary" type="button">Apply</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-truck fa-2x" style="color: var(--primary-color);"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Free Shipping</h5>
                                <p class="mb-0">On orders over $50</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <i class="fas fa-undo fa-2x" style="color: var(--secondary-color);"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Easy Returns</h5>
                                <p class="mb-0">30 days return policy</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-lock fa-2x" style="color: var(--success-color);"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Secure Checkout</h5>
                                <p class="mb-0">100% secure payment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-shopping-cart fa-5x mb-3" style="color: var(--primary-color);"></i>
                        <h3 class="mb-3">Your cart is empty</h3>
                        <p class="mb-4">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('items.index') }}" class="btn btn-primary">
                            <i class="fas fa-store me-2"></i>Start Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- You May Also Like -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3 class="mb-4 star-icon">You May Also Like</h3>
            <div class="divider mb-4"></div>
            
            <div class="row">
                @for($i = 1; $i <= 4; $i++)
                    <div class="col-md-3 mb-4">
                        <div class="item-card">
                            <img src="https://via.placeholder.com/300x300?text=Product+{{ $i }}" alt="Product {{ $i }}">
                            <div class="card-body">
                                <h5 class="card-title">Suggested Product {{ $i }}</h5>
                                <p class="card-text">This is a product you might be interested in!</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">${{ rand(10, 50) }}.99</span>
                                    <a href="#" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function incrementQuantity(button) {
        const input = button.parentNode.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        input.value = currentValue + 1;
    }
    
    function decrementQuantity(button) {
        const input = button.parentNode.querySelector('.quantity-input');
        const currentValue = parseInt(input.value);
        if (currentValue > 1) {
            input.value = currentValue - 1;
        }
    }
</script>
@endsection