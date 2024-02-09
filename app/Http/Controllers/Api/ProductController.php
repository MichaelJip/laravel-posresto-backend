<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //index api
    public function index()
    {
        // get all products
        // $product = Product::all();
        // pagination
        $product = Product::paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $product
        ], 200);
    }
}
