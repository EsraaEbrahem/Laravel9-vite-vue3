<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientProductsController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->orderBy('rate', 'DESC')
            ->where('is_active', true)
            ->limit($request->limit)
            ->get();
        return response()->json($products);
    }

}
