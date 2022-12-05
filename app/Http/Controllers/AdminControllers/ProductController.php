<?php

namespace App\Http\Controllers\AdminControllers;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return response()->json($products);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $image = '';
//        $file = $request->image;
//        $name = $request->name . '_' . Carbon::now() . '_' . $file->getClientOriginalName();
//        $name = str_replace(':', '-', $name);
//        $path = storage_path('app/products') . '/' . $name;
//        $image = Image::make($file)->encode('webp', 70);
//        $image->save($path);

        $product = new Product([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'image' => $image,
            'cost' => $request->cost,
            'rate' => 1,
            'available_stock' => $request->available_stock,
            'created_by' => auth('sanctum')->user()->id,
        ]);

        $product->save();
        return response()->json('Product created!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::with('category')->where('id', $id)->first();
        return response()->json($product);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return response()->json('Product updated');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $orderDetails = OrderDetail::where('product_id', $id)->count();
        if ($orderDetails > 0)
            return response()->json('Cannot delete this product');

        $product = Product::find($id);
        $product->delete();
        return response()->json(' deleted!');
    }
}
