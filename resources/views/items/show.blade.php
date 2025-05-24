@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Item Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Name:</strong>
                        {{ $item->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Description:</strong>
                        {{ $item->description }}
                    </div>
                    <div class="mb-3">
                        <strong>Price:</strong>
                        {{ $item->price }}
                    </div>
                    <div class="mb-3">
                        <strong>Image:</strong>
                        @if ($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="max-width: 300px;">
                        @else
                            No Image
                        @endif
                    </div>
                    <a href="{{ route('items.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection