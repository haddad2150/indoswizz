@extends('adminlte::page'))

@section('title', 'Cart')

@section('content_header')
    <h1>Cart</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-sm">
          <h4 class="mr-2">Total: Rp. {{ $total }}</h4>
        </div>
        @if($total > 0)
          <div class="col-sm float-right">
            <div class="text-right">
              <form action="{{ route('transaction.create') }}" method="post" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-info">Bayar</button>
              </form>
            </div>
          </div>
        @endif
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach($cartItems as $cartItem)
          <div class="col-sm-3">
            <div class="card">
              <img src="/image/product-image-placeholder.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="card-title">Name: {{ $cartItem->product->name }}</h3>
                <p class="card-text text-muted mb-0">SKU: {{ $cartItem->product->sku }}</p>
                <p class="card-text text-muted">Category: {{ ucfirst($cartItem->product->category) }}</p>
                <p class="card-text text-muted">Qty: {{ $cartItem->qty }}</p>
                <p class="card-text text-muted">Price: Rp. {{ $cartItem->product->price }}</p>
                <p class="card-text text-muted">Sub Total: Rp. {{ $cartItem->total() }}</p>
                <div class="text-right">
                <form action="{{ route('cart_item.update', $cartItem->id) }}" method="post" style="display: inline;">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="qty" value="{{ $cartItem->qty + 1 }}">
                  <button type="submit" class="btn btn-sm btn-primary">+</button>
                </form>
                <form action="{{ route('cart_item.update', $cartItem->id) }}" method="post" style="display: inline;">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="qty" value="{{ $cartItem->qty - 1 }}">
                  <button type="submit" class="btn btn-sm btn-danger">-</button>
                </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@stop