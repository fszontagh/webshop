@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Edit Product: {{ $item->name }}</h1>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
            <div class="divider mb-4"></div>
        </div>
    </div>
    
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
                    
                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Product Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $item->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $item->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                                    <option value="">Select Category</option>
                                                    <option value="fashion" {{ old('category', $item->category) == 'fashion' ? 'selected' : '' }}>Fashion</option>
                                                    <option value="beauty" {{ old('category', $item->category) == 'beauty' ? 'selected' : '' }}>Beauty</option>
                                                    <option value="tech" {{ old('category', $item->category) == 'tech' ? 'selected' : '' }}>Tech</option>
                                                    <option value="accessories" {{ old('category', $item->category) == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                                </select>
                                                @error('category')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="tags" class="form-label">Tags</label>
                                                <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags', $item->tags) }}" placeholder="Separate tags with commas">
                                                @error('tags')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pricing and Inventory -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Pricing and Inventory</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="price" class="form-label">Regular Price ($)</label>
                                                <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $item->price) }}" required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="sale_price" class="form-label">Sale Price ($)</label>
                                                <input type="number" step="0.01" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" value="{{ old('sale_price', $item->sale_price) }}">
                                                @error('sale_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="stock" class="form-label">Stock Quantity</label>
                                                <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $item->stock) }}">
                                                @error('stock')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="sku" class="form-label">SKU</label>
                                                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $item->sku) }}">
                                                @error('sku')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="weight" class="form-label">Weight (kg)</label>
                                                <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $item->weight) }}">
                                                @error('weight')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $item->featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="featured">
                                                Featured Product
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Additional Information -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Additional Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="specifications" class="form-label">Specifications</label>
                                            <textarea class="form-control @error('specifications') is-invalid @enderror" id="specifications" name="specifications" rows="3">{{ old('specifications', $item->specifications) }}</textarea>
                                            @error('specifications')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Enter product specifications in JSON format or as bullet points.</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">Meta Title</label>
                                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $item->meta_title) }}">
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">Meta Description</label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $item->meta_description) }}</textarea>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Media and Status -->
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Product Image</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Main Image</label>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Leave empty to keep the current image.</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="image-preview text-center p-3 bg-light rounded">
                                                @if($item->image)
                                                    <img id="imagePreview" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid rounded">
                                                @else
                                                    <img id="imagePreview" src="https://via.placeholder.com/300x300?text=No+Image" alt="No Image" class="img-fluid rounded">
                                                @endif
                                            </div>
                                        </div>
                                        
                                        @if($item->image)
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                                <label class="form-check-label" for="remove_image">
                                                    Remove current image
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Additional Images</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="additional_images" class="form-label">Gallery Images</label>
                                            <input type="file" class="form-control @error('additional_images') is-invalid @enderror" id="additional_images" name="additional_images[]" accept="image/*" multiple>
                                            @error('additional_images')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Select multiple files to add to the gallery.</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div id="additionalImagesPreview" class="row g-2">
                                                <!-- Additional images previews will be shown here -->
                                                @if(isset($item->gallery_images) && is_array($item->gallery_images))
                                                    @foreach($item->gallery_images as $index => $image)
                                                        <div class="col-4 mb-2">
                                                            <div class="position-relative">
                                                                <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image {{ $index + 1 }}" class="img-fluid rounded">
                                                                <div class="form-check position-absolute" style="bottom: 5px; right: 5px;">
                                                                    <input class="form-check-input" type="checkbox" id="remove_gallery_{{ $index }}" name="remove_gallery[]" value="{{ $index }}">
                                                                    <label class="form-check-label" for="remove_gallery_{{ $index }}">
                                                                        <span class="badge bg-danger">Remove</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Product Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                                <option value="active" {{ old('status', $item->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="draft" {{ old('status', $item->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="archived" {{ old('status', $item->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="visibility" class="form-label">Visibility</label>
                                            <select class="form-select @error('visibility') is-invalid @enderror" id="visibility" name="visibility">
                                                <option value="public" {{ old('visibility', $item->visibility) == 'public' ? 'selected' : '' }}>Public</option>
                                                <option value="private" {{ old('visibility', $item->visibility) == 'private' ? 'selected' : '' }}>Private</option>
                                            </select>
                                            @error('visibility')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.items.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image preview functionality
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('imagePreview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Additional images preview
    document.getElementById('additional_images').addEventListener('change', function(e) {
        const files = e.target.files;
        const previewContainer = document.getElementById('additionalImagesPreview');
        
        // Clear new image previews but keep existing ones
        const existingImages = previewContainer.querySelectorAll('.existing-image');
        previewContainer.innerHTML = '';
        
        // Add back existing images
        existingImages.forEach(img => {
            previewContainer.appendChild(img);
        });
        
        // Add new image previews
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            
            reader.onload = function(event) {
                const col = document.createElement('div');
                col.className = 'col-4 mb-2';
                
                const img = document.createElement('img');
                img.src = event.target.result;
                img.className = 'img-fluid rounded';
                img.alt = 'New Gallery Image';
                
                col.appendChild(img);
                previewContainer.appendChild(col);
            };
            
            reader.readAsDataURL(file);
        }
    });
    
    // Handle remove image checkbox
    const removeImageCheckbox = document.getElementById('remove_image');
    if (removeImageCheckbox) {
        removeImageCheckbox.addEventListener('change', function() {
            const imagePreview = document.getElementById('imagePreview');
            if (this.checked) {
                imagePreview.style.opacity = '0.3';
            } else {
                imagePreview.style.opacity = '1';
            }
        });
    }
</script>
@endsection