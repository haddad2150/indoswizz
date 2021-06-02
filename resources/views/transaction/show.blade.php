@extends('adminlte::page'))

@section('title', 'Transaction Detail')

@section('content_header')
    <h1>Transaction Detail</h1>
@stop

@section('content')
  @if($transaction->status == 'waiting_for_payment')
    <div class="alert alert-success" role="alert">
      Pembayaran melalui transfer ke rekening bank ABC 1234567890 A.N Jhon Doe. Silakan lakukan konfirmasi jika pembayaran telah dilakukan.
    </div>
    <div class="card">
      <div class="card-header">
        Payment Confirmation
      </div>
      <div class="card-body">
        <form action="{{ route('transaction.payment_confirmation.create', $transaction->uuid) }}" method="post">
          @csrf
          <div class="form-group">
            <input type="file" name="" id="">
          </div>
          <button type="submit" class="btn btn-info">Confirm Payment</button>
        </form>
      </div>
    </div>
  @endif
  @if($transaction->status == 'confirmed')
    <div class="alert alert-success" role="alert">
      Pembayaran telah dikonfirmasi.
    </div>
  @endif
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-sm">
          <h4>ID: {{ $transaction->uuid }} ({{ $transaction->status }})</h4>
        </div>
        <div class="col-sm float-right">
          <div class="text-right">
            <h4 class="mr-2">Total: Rp. {{ $transaction->total() }}</h4>
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        @foreach($transaction->transactionItems as $transactionItem)
          <div class="col-sm-3">
            <div class="card">
              <img src="/image/product-image-placeholder.jpg" alt="" class="card-img-top">
              <div class="card-body">
                <h3 class="card-title">Name: {{ $transactionItem->product->name }}</h3>
                <p class="card-text text-muted mb-0">SKU: {{ $transactionItem->product->sku }}</p>
                <p class="card-text text-muted">Category: {{ ucfirst($transactionItem->product->category) }}</p>
                <p class="card-text text-muted">Qty: {{ $transactionItem->qty }}</p>
                <p class="card-text text-muted">Price: Rp. {{ $transactionItem->product->price }}</p>
                <p class="card-text text-muted">Sub Total: Rp. {{ $transactionItem->total() }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@stop