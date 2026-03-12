<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status','active')
                    ->where('stock','>',0)
                    ->get();

        return response()->json($products);
    }
}
