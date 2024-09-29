@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <h3 class="card-header text-center bg-info text-white">Nouvel Arrivage !</h3>
                <div class="card-body">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow">
                                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->title }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->title }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">{{ $product->price }} DH</span>
                                            @if($product->old_price)
                                                <span class="text-danger">
                                                    <strike>{{ $product->old_price }} DH</strike>
                                                </span>
                                            @endif
                                        </div>
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-block btn-outline-primary mt-3">View Details</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <h3 class="card-header text-center bg-info text-white">Categories</h3>
                <ul class="list-group list-group-flush">
                    @foreach ($catigories as $category)
                        <li class="list-group-item">
                            <a href="{{ route('category.product', $category->slug) }}" class="list-group-item list-group-item-action">
                                {{ $category->title }}
                                <span class="badge badge-primary badge-pill">{{ $category->products->count() }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
