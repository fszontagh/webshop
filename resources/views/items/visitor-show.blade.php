@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Shop</a></li>
                    @if($item->category)
                        <li class="breadcrumb-item"><a href="{{ route('items.index', ['category' => $item->category]) }}">{{ ucfirst($item->category) }}</a></li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $item->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body p-0">
                    @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid rounded">
                    @else
                        <img src="https://via.placeholder.com/600x600?text=No+Image" alt="No Image" class="img-fluid rounded">
                    @endif
                </div>
            </div>
            
            <!-- Additional Images (if available) -->
            <div class="row">
                @for($i = 1; $i <= 4; $i++)
                    <div class="col-3">
                        <div class="card mb-2">
                            <div class="card-body p-0">
                                <img src="https://via.placeholder.com/150x150?text=Image+{{ $i }}" alt="Additional Image {{ $i }}" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-3">{{ $item->name }}</h1>
                    
                    <div class="mb-3">
                        <div class="d-flex">
                            <div style="color: var(--warning-color);">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span class="ms-2">(4.5/5 - 24 reviews)</span>
                        </div>
                    </div>
                    
                    <div class="divider mb-3"></div>
                    
                    <h2 class="price mb-4">${{ number_format($item->price, 2) }}</h2>
                    
                    <p class="mb-4">{{ $item->description }}</p>
                    
                    @if($item->category)
                        <p class="mb-3">
                            <strong>Category:</strong> 
                            <a href="{{ route('items.index', ['category' => $item->category]) }}">{{ ucfirst($item->category) }}</a>
                        </p>
                    @endif
                    
                    <p class="mb-4"><strong>Availability:</strong> <span class="text-success">In Stock</span></p>
                    
                    <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decrementQuantity()">-</button>
                                    <input type="number" name="quantity" id="quantity" class="form-control text-center" value="1" min="1">
                                    <button type="button" class="btn btn-outline-secondary" onclick="incrementQuantity()">+</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <button class="btn btn-outline-primary">
                            <i class="far fa-heart me-1"></i>Add to Wishlist
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-share-alt me-1"></i>Share
                        </button>
                    </div>
                    
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-truck fa-2x"></i>
                            </div>
                            <div>
                                <strong>Free Shipping</strong>
                                <p class="mb-0">On orders over $50</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="itemTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="itemTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <h4 class="mb-3">Product Description</h4>
                            <p>{{ $item->description }}</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor mauris molestie elit, et lacinia ipsum quam nec dui.</p>
                            <p>Donec pretium posuere tellus. Proin quam nisl, tincidunt et, mattis eget, convallis nec, purus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                            
                            <h5 class="mt-4 mb-3">Features:</h5>
                            <ul>
                                <li>High-quality materials</li>
                                <li>Durable and long-lasting</li>
                                <li>Stylish design</li>
                                <li>Perfect for everyday use</li>
                                <li>Makes a great gift</li>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <h4 class="mb-4">Customer Reviews</h4>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div style="color: var(--warning-color);">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="ms-2 fw-bold">Amazing product!</span>
                                </div>
                                <p class="mb-1">This is exactly what I was looking for! The quality is amazing and it arrived so quickly.</p>
                                <small class="text-muted">By Sarah, 2 weeks ago</small>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div style="color: var(--warning-color);">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="ms-2 fw-bold">Great value</span>
                                </div>
                                <p class="mb-1">Really happy with my purchase. Would definitely buy again!</p>
                                <small class="text-muted">By Emma, 1 month ago</small>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <div style="color: var(--warning-color);">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <span class="ms-2 fw-bold">Good but could be better</span>
                                </div>
                                <p class="mb-1">I like it but I wish it came in more colors. Overall pretty good though!</p>
                                <small class="text-muted">By Olivia, 2 months ago</small>
                            </div>
                            
                            <div class="divider my-4"></div>
                            
                            <h5 class="mb-3">Write a Review</h5>
                            <form>
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Your Rating</label>
                                    <select class="form-select" id="rating">
                                        <option value="5">5 Stars - Excellent</option>
                                        <option value="4">4 Stars - Very Good</option>
                                        <option value="3">3 Stars - Good</option>
                                        <option value="2">2 Stars - Fair</option>
                                        <option value="1">1 Star - Poor</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="reviewTitle" class="form-label">Review Title</label>
                                    <input type="text" class="form-control" id="reviewTitle" placeholder="Summarize your review">
                                </div>
                                <div class="mb-3">
                                    <label for="reviewText" class="form-label">Your Review</label>
                                    <textarea class="form-control" id="reviewText" rows="3" placeholder="Tell others what you think about this product"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                            <h4 class="mb-3">Shipping Information</h4>
                            <p>We offer free standard shipping on all orders over $50. For orders under $50, a flat shipping fee of $5.99 will be applied.</p>
                            <p>Standard shipping typically takes 3-5 business days. Express shipping is available for an additional fee and typically takes 1-2 business days.</p>
                            
                            <h4 class="mt-4 mb-3">Return Policy</h4>
                            <p>We accept returns within 30 days of delivery for a full refund or exchange. Items must be in their original condition with tags attached.</p>
                            <p>To initiate a return, please contact our customer service team at support@girlywebshop.com or through your account dashboard.</p>
                            
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-circle me-2"></i>Please note that personalized items cannot be returned unless they arrive damaged or defective.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h3 class="mb-4 star-icon">You May Also Like</h3>
            <div class="divider mb-4"></div>
            
            <div class="row">
                @for($i = 1; $i <= 4; $i++)
                    <div class="col-md-3 mb-4">
                        <div class="item-card">
                            <img src="https://via.placeholder.com/300x300?text=Related+{{ $i }}" alt="Related Product {{ $i }}">
                            <div class="card-body">
                                <h5 class="card-title">Related Product {{ $i }}</h5>
                                <p class="card-text">This is a related product you might be interested in!</p>
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
    function incrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    }
    
    function decrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }
</script>
@endsection