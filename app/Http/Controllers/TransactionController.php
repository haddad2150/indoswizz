<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())->get();

        return view('transaction.index', [
            'transactions'   => $transactions
        ]);
    }

    function create(Request $request)
    {
        $transaction = Transaction::create([
            'user_id'   => Auth::id(),
            'uuid'      => Str::uuid()
        ]);

        $cartItems = CartItem::where('user_id', Auth::id())->get();
        $cartItems->each(function ($cartItem) use ($transaction) {
            TransactionItem::create([
                'transaction_id'    => $transaction->id,
                'product_id'        => $cartItem->product_id,
                'qty'               => $cartItem->qty
            ]);

            $cartItem->delete();
        });

        return redirect(route('transaction.show', $transaction->uuid));
    }

    function show($uuid)
    {
        $transaction = Transaction::firstWhere('uuid', $uuid);

        return view('transaction.show', [
            'transaction'   => $transaction
        ]);
    }
}
