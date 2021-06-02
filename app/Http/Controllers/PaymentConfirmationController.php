<?php

namespace App\Http\Controllers;

use App\Models\Transaction;

use Illuminate\Http\Request;

class PaymentConfirmationController extends Controller
{
    function create($uuid) 
    {
        $transaction = Transaction::firstWhere('uuid', $uuid);

        $transaction->update([
            'status'    => 'confirmed'
        ]);

        return back();
    }
}
