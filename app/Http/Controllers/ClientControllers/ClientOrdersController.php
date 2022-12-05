<?php

namespace App\Http\Controllers\ClientControllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class ClientOrdersController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', auth('sanctum')->user()->id)->get();
        return response()->json($orders);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $order = new Order([

        ]);

        $order->save();
        return response()->json('Order created!');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = Order::find($id);
        return response()->json($order);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $order = Order::where('id', $id)
                ->where('user_id', auth('sanctum')->user()->id)
                ->first();
            if ($order) {
                OrderDetail::where('order_id', $id)->delete();
                Order::where('id', $id)->delete();
            } else {
                throwException('Cannot deleted others orders');
            }

            DB::commit();
            return response()->json(' deleted!');
        } catch (\Throwable $exception) {
            DB::rollBack();
            return response()->json('Failed!');
        }
    }
}
