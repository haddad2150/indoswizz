<?php

namespace App\Http\Controllers;

use App\Models\CartItem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())
                             ->orderBy('id')
                             ->get();
        
        $total = $cartItems->sum(function ( $cartItem) { return $cartItem->total(); });

        return view('cart_item.index', [
            'cartItems' => $cartItems,
            'total'     => $total
        ]);
    }

    function create(Request $request)
    {
        $existingCartItem = CartItem::where('user_id', Auth::id())
                                    ->where('product_id', $request->input('product_id'))
                                    ->first();
        if($existingCartItem) {
            $existingCartItem->increment('qty');
        } else {
            $newCartItem = CartItem::create([
                'user_id'       => Auth::id(),
                'product_id'    => $request->input('product_id'),
                'qty'           => 1
            ]);
        }

        return redirect(route('cart_item.index'));
    }

    function update(Request $request, $id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('id', $id)
                            ->first();
        
        $cartItem->update([
            'qty'   => $request->input('qty')
        ]);

        if($cartItem->fresh()->qty <= 0) {
            $cartItem->delete();
        }

        return back();
    }
}
