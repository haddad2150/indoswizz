@extends('adminlte::page'))

@section('title', 'Transactions')

@section('content_header')
    <h1>Transactions</h1>
@stop

@section('content')
  <div class="card">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Date</th>
            <th scope="col">ID</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($transactions as $transaction)
            <tr>
              <td>{{ $transaction->created_at->toDayDateTimeString() }}</td>
              <td>{{ $transaction->uuid }}</td>
              <td>Rp. {{ $transaction->total() }}</td>
              <td>{{ $transaction->status }}</td>
              <td>
                <a href="{{ route('transaction.show', $transaction->uuid) }}">Lihat</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop