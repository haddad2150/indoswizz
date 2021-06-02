<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'status'
    ];

    function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

    function total()
    {
        return $this->transactionItems->sum(function ($transactionItem) {
            return $transactionItem->total();
        });
    }
}
