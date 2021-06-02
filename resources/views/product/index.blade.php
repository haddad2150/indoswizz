@extends('adminlte::page'))

@section('title', 'Products')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-sm float-right">
          <div class="filters text-right">
            <label class="mr-2">Category:</label>
            <select name="category" onchange="location = this.value;">
              <option value="{{ route('product.index', ['category' => null, 'price' => request()->query('price')]) }}" 
                      {{ request()->query('category') == null ? 'selected' : '' }}>
                Semua
              </option>
              <option value="{{ route('product.index', ['category' => 'mobil', 'price' => request()->query('price')]) }}" 
                      {{ request()->query('category') == 'mobil' ? 'selected' : '' }}>
                Mobil
              </option>
              <option value="{{ route('product.index', ['category' => 'motor', 'price' => request()->query('price')]) }}" 
                      {{ request()->query('category') == 'motor' ? 'selected' : '' }}>
                Motor
              </option>
            </select>
            <label class="ml-2 mr-2">Price:</label>
            <select name="price" onchange="location = this.value;">
              <option value="{{ route('product.index', ['price' => 'low_to_high', 'category' => request()->query('category')]) }}" 
                      {{ request()->query('price') == 'low_to_high' ? 'selected' : '' }}>
                Low to High
              </option>
              <option value="{{ route('product.index', ['price' => 'high_to_low', 'category' => request()->query('category')]) }}" 
                      {{ request()->query('price') == 'high_to_low' ? 'selected' : '' }}>
                High to Low
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach($products as $product)
          <div class="col-sm-3">
            <div class="card">
              <img src="/image/product-image-placeholder.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="card-title">Name: {{ $product->name }}</h3>
                <p class="card-text text-muted mb-0">SKU: {{ $product->sku }}</p>
                <p class="card-text text-muted">Category: {{ ucfirst($product->category) }}</p>
                <p class="card-text text-muted">Stock: {{ $product->stock }}</p>
                <p class="card-text text-muted">Price: Rp. {{ $product->price }}</p>
                <p class="card-text">{{ $product->description }}</p>
                <form action="{{ route('cart_item.create') }}" method="post">
                  @csrf
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                  <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@stop