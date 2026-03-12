<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendOrderConfirmationEmail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function orders()
    {
        $orders = Order::where('user_id',auth()->id())
                    ->latest()
                    ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $order = Order::create([
                'user_id'=>auth()->id(),
                'total_items'=>0,
                'total_amount'=>0
            ]);

            $totalAmount = 0;
            $totalItems = 0;

            foreach ($request->products as $item) {

                $product = Product::find($item['product_id']);

                if(!$product || $product->stock < $item['qty']){
                    throw new Exception('Quantity is geater than available stock');
                }

                $total = $product->price * $item['qty'];

                OrderItem::create([
                    'order_id'=>$order->id,
                    'product_id'=>$product->id,
                    'quantity'=>$item['qty'],
                    'price'=>$product->price,
                    'total'=>$total
                ]);

                $product->decrement('stock',$item['qty']);

                $totalAmount += $total;
                $totalItems += $item['qty'];
            }

            $order->update([
                'total_items'=>$totalItems,
                'total_amount'=>$totalAmount
            ]);

            DB::commit();

            SendOrderConfirmationEmail::dispatch($order);

            return response()->json([
                'message'=>'Order placed successfully'
            ]);

        } catch(Exception $e){

            DB::rollback();

            return response()->json([
                'message'=>$e->getMessage()
            ],400);
        }
    }

    public function show($id)
    {
        $order = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()->json($order);
    }
}
