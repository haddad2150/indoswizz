<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'qty'
    ];

    function product()
    {
        return $this->belongsTo(Product::class);
    }

    function total()
    {
        return $this->qty * $this->product->price;
    }
}
