<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function index(Request $request)
    {
        if(!$this->hasFilters($request)) {
            $products = Product::all();
            return view('product.index', [
                'products'  => $products
            ]);
        }

        $query = Product::query();

        if ($category = $request->query('category')) {
            $query = $query->where('category', strtolower($category));
        } 

        if ($price = $request->query('price')) {
            if (strtolower($price) == 'low_to_high') {
                $query = $query->orderBy('price');
            } else {
                $query = $query->orderBy('price', 'desc');
            }
        }

        return view('product.index', [
            'products'  => $query->get()
        ]);
    }

    private function hasFilters($request)
    {
        return $request->query('category') || $request->query('price');
    }
}
