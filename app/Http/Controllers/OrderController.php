<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{   
    use ApiResponse;
    public function customerOrderStore(Request $request){
        try{
            $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            ]);

            $user = Auth::user();

            $product = Product::find($validated['product_id']);

            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'total' => $product->price,
            ]);

            if($product->quantity > 0){
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ]);
                $product->quantity = $product->quantity - 1;
                $product->save();
            }
            else{
                return $this->responseWithError(false,'Product is out of stock', [], 404);
            }
            return $this->responseWithSuccess(true,'Order placed successfully', 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
        }
    }

    public function adminOrderList(){
        try{
            $orders = Order::orderBy('created_at', 'desc')->get();
            return view('pages.dashboard.admin.orders.order-page', compact('orders'));
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
        }
    }

    public function customerOrderList(){
        try{
            $user = Auth::user();
            $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            return view('pages.dashboard.customer.orders.order-page', compact('orders'));

        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
        }
    }
}
