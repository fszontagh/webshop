@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1 class="heart-icon">Checkout</h1>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8">
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', auth()->user()->name ?? '') }}" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Street Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="address2" class="form-label">Apartment, Suite, etc. (optional)</label>
                            <input type="text" class="form-control @error('address2') is-invalid @enderror" id="address2" name="address2" value="{{ old('address2') }}">
                            @error('address2')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}" required>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State/Province</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" required>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="zip" class="form-label">Zip/Postal Code</label>
                                <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip') }}" required>
                                @error('zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select @error('country') is-invalid @enderror" id="country" name="country" required>
                                <option value="">Select Country</option>
                                <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                                <option value="DE" {{ old('country') == 'DE' ? 'selected' : '' }}>Germany</option>
                                <option value="FR" {{ old('country') == 'FR' ? 'selected' : '' }}>France</option>
                            </select>
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="save_address" name="save_address" value="1" {{ old('save_address') ? 'checked' : '' }}>
                            <label class="form-check-label" for="save_address">
                                Save this address for future orders
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping_standard" value="standard" {{ old('shipping_method', 'standard') == 'standard' ? 'checked' : '' }}>
                            <label class="form-check-label" for="shipping_standard">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Standard Shipping</strong>
                                        <p class="mb-0 text-muted">3-5 business days</p>
                                    </div>
                                    <span>{{ $total >= 50 ? 'Free' : '$5.99' }}</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping_express" value="express" {{ old('shipping_method') == 'express' ? 'checked' : '' }}>
                            <label class="form-check-label" for="shipping_express">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Express Shipping</strong>
                                        <p class="mb-0 text-muted">1-2 business days</p>
                                    </div>
                                    <span>$12.99</span>
                                </div>
                            </label>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping_overnight" value="overnight" {{ old('shipping_method') == 'overnight' ? 'checked' : '' }}>
                            <label class="form-check-label" for="shipping_overnight">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Overnight Shipping</strong>
                                        <p class="mb-0 text-muted">Next business day</p>
                                    </div>
                                    <span>$19.99</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_credit" value="credit" {{ old('payment_method', 'credit') == 'credit' ? 'checked' : '' }} onchange="togglePaymentDetails('credit')">
                            <label class="form-check-label" for="payment_credit">
                                <i class="fab fa-cc-visa me-2"></i>Credit Card
                            </label>
                        </div>
                        
                        <div id="credit_card_details" class="mb-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="card_name" class="form-label">Name on Card</label>
                                    <input type="text" class="form-control @error('card_name') is-invalid @enderror" id="card_name" name="card_name" value="{{ old('card_name') }}">
                                    @error('card_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="card_number" class="form-label">Card Number</label>
                                    <input type="text" class="form-control @error('card_number') is-invalid @enderror" id="card_number" name="card_number" value="{{ old('card_number') }}" placeholder="XXXX XXXX XXXX XXXX">
                                    @error('card_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="card_expiry_month" class="form-label">Expiry Month</label>
                                    <select class="form-select @error('card_expiry_month') is-invalid @enderror" id="card_expiry_month" name="card_expiry_month">
                                        <option value="">Month</option>
                                        @for($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ old('card_expiry_month') == $i ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                                        @endfor
                                    </select>
                                    @error('card_expiry_month')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="card_expiry_year" class="form-label">Expiry Year</label>
                                    <select class="form-select @error('card_expiry_year') is-invalid @enderror" id="card_expiry_year" name="card_expiry_year">
                                        <option value="">Year</option>
                                        @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                                            <option value="{{ $i }}" {{ old('card_expiry_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    @error('card_expiry_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="card_cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control @error('card_cvv') is-invalid @enderror" id="card_cvv" name="card_cvv" value="{{ old('card_cvv') }}" placeholder="XXX">
                                    @error('card_cvv')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_paypal" value="paypal" {{ old('payment_method') == 'paypal' ? 'checked' : '' }} onchange="togglePaymentDetails('paypal')">
                            <label class="form-check-label" for="payment_paypal">
                                <i class="fab fa-paypal me-2"></i>PayPal
                            </label>
                        </div>
                        
                        <div id="paypal_details" class="mb-3 d-none">
                            <p class="text-muted">You will be redirected to PayPal to complete your payment.</p>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment_apple" value="apple" {{ old('payment_method') == 'apple' ? 'checked' : '' }} onchange="togglePaymentDetails('apple')">
                            <label class="form-check-label" for="payment_apple">
                                <i class="fab fa-apple-pay me-2"></i>Apple Pay
                            </label>
                        </div>
                        
                        <div id="apple_details" class="mb-3 d-none">
                            <p class="text-muted">You will be prompted to complete your payment with Apple Pay.</p>
                        </div>
                    </div>
                </div>
                
                <!-- Order Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Notes (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="order_notes" name="order_notes" rows="3" placeholder="Special instructions for delivery or any other notes">{{ old('order_notes') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-4">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Cart
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-credit-card me-2"></i>Place Order
                    </button>
                </div>
            </form>
        </div>
        
        <div class="col-md-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <span class="badge bg-primary rounded-pill">{{ $item['quantity'] }}</span>
                                    </div>
                                    <span>{{ Str::limit($item['name'], 20) }}</span>
                                </div>
                                <span>${{ number_format($item['subtotal'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="divider mb-3"></div>
                    
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
                </div>
            </div>
            
            <!-- Coupon -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Have a Coupon?</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Coupon code">
                        <button class="btn btn-outline-primary" type="button">Apply</button>
                    </div>
                </div>
            </div>
            
            <!-- Security Info -->
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-lock fa-2x" style="color: var(--success-color);"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Secure Checkout</h5>
                            <p class="mb-0">Your data is protected</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3">
                            <i class="fas fa-shield-alt fa-2x" style="color: var(--primary-color);"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Privacy Protected</h5>
                            <p class="mb-0">Your information is private</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-credit-card fa-2x" style="color: var(--secondary-color);"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Payment Options</h5>
                            <p class="mb-0">Multiple payment methods</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePaymentDetails(method) {
        // Hide all payment details
        document.getElementById('credit_card_details').classList.add('d-none');
        document.getElementById('paypal_details').classList.add('d-none');
        document.getElementById('apple_details').classList.add('d-none');
        
        // Show the selected payment method details
        if (method === 'credit') {
            document.getElementById('credit_card_details').classList.remove('d-none');
        } else if (method === 'paypal') {
            document.getElementById('paypal_details').classList.remove('d-none');
        } else if (method === 'apple') {
            document.getElementById('apple_details').classList.remove('d-none');
        }
    }
    
    // Initialize the payment details visibility
    document.addEventListener('DOMContentLoaded', function() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        togglePaymentDetails(selectedMethod);
    });
</script>
@endsection