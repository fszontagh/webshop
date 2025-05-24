@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Hero Section -->
            <div class="card mb-5">
                <div class="card-body text-center p-5" style="background: linear-gradient(rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8)), url('https://images.unsplash.com/photo-1607083206968-13611e3d76db?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80'); background-size: cover; background-position: center;">
                    <h1 class="display-4 fw-bold mb-4" style="color: var(--primary-color);">Welcome to Girly Webshop! <span class="sparkle">✨</span></h1>
                    <p class="lead mb-4">The cutest online shop for all your favorite things!</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('items.index') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Shop Now
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Join Us
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
            
            <!-- Featured Categories -->
            <h2 class="text-center mb-4 heart-icon">Featured Categories</h2>
            <div class="divider mb-4"></div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-tshirt fa-4x mb-3" style="color: var(--primary-color);"></i>
                            <h3 class="card-title">Fashion</h3>
                            <p class="card-text">Cute tops, skirts, and accessories for every style!</p>
                            <a href="{{ route('items.index') }}?category=fashion" class="btn btn-outline-primary">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-magic fa-4x mb-3" style="color: var(--secondary-color);"></i>
                            <h3 class="card-title">Beauty</h3>
                            <p class="card-text">Makeup, skincare, and beauty tools for a perfect look!</p>
                            <a href="{{ route('items.index') }}?category=beauty" class="btn btn-outline-primary">Explore</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 text-center">
                        <div class="card-body">
                            <i class="fas fa-headphones fa-4x mb-3" style="color: var(--accent-color);"></i>
                            <h3 class="card-title">Tech</h3>
                            <p class="card-text">Colorful gadgets and tech accessories for the modern girl!</p>
                            <a href="{{ route('items.index') }}?category=tech" class="btn btn-outline-primary">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Featured Products -->
            <h2 class="text-center mb-4 mt-5 star-icon">Featured Products</h2>
            <div class="divider mb-4"></div>
            
            <div class="row">
                @for ($i = 1; $i <= 4; $i++)
                <div class="col-md-3 mb-4">
                    <div class="item-card">
                        <img src="https://via.placeholder.com/300x300?text=Product+{{ $i }}" alt="Product {{ $i }}">
                        <div class="card-body">
                            <h5 class="card-title">Cute Product {{ $i }}</h5>
                            <p class="card-text">This is a super cute product that you'll absolutely love!</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">${{ rand(10, 50) }}.99</span>
                                <a href="{{ route('items.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
            
            <!-- Testimonials -->
            <h2 class="text-center mb-4 mt-5 sparkle-icon">What Our Customers Say</h2>
            <div class="divider mb-4"></div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-center mb-3">
                                <div style="color: var(--warning-color);">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="card-text text-center">"I absolutely love this shop! Everything is so cute and the quality is amazing. Will definitely shop here again!"</p>
                            <p class="text-center mb-0 fw-bold">- Emma, 15</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-center mb-3">
                                <div style="color: var(--warning-color);">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="card-text text-center">"The shipping was super fast and everything came in the cutest packaging! My friends are so jealous!"</p>
                            <p class="text-center mb-0 fw-bold">- Sophia, 14</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-center mb-3">
                                <div style="color: var(--warning-color);">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <p class="card-text text-center">"I got the cutest phone case ever! The website is so easy to use and has so many amazing things!"</p>
                            <p class="text-center mb-0 fw-bold">- Olivia, 13</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="card mt-5">
                <div class="card-body text-center p-5">
                    <h2 class="mb-4">Join Our Newsletter!</h2>
                    <p class="mb-4">Stay updated with our latest products and exclusive offers!</p>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form class="d-flex">
                                <input type="email" class="form-control me-2" placeholder="Your email address">
                                <button type="submit" class="btn btn-primary">Subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection