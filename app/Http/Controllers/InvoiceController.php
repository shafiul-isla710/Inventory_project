<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use App\Traits\ApiResponse;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\InvoiceResource;
use App\Http\Requests\InvoiceStoreRequest;


class InvoiceController extends Controller
{
   use ApiResponse;
    // public function store(Request $request)
    // {

    //     // DB::beginTransaction();
    //     try{
    //         $order_id = $request->order_id;
    //         $customer_id = $request->customer_id;
    //         $user_id = Auth::user()->id;
    //         $invoice_number ='INV-'.uniqid();
    //         $invoice_date = date('Y-m-d H:i:s');
    //         $notes = '';

    //         //product array
    //         // $products = $request->products;
    //         // $quantities = $request->quantity;
    //         // $amounts = $request->amount;

    //         $grose_total_amount = 0;
    //         $total_amount = 0;

    //         // foreach($products as $key => $value){
    //         //     $product_id = $products[$key];
    //         //     $quantity = $quantities[$key];
    //         //     $product = Product::find($product_id);
    //         //     if(!$product || $product->quantity < $quantity){
    //         //         DB::rollBack();
    //         //         return $this->responseWithError('Product quantity is not enough', [], 500);
    //         //     }
    //         // }

    //         $invoice = Invoice::create([
    //             'order_id' => $order_id,
    //             'customer_id' => $customer_id,
    //             'user_id' => $user_id,
    //             'invoice_number' => $invoice_number,
    //             'invoice_date' => $invoice_date,
    //             'total_amount' => 0,
    //             'notes' => $notes
    //         ]);

    //         $orderDetails = OrderDetails::where('order_id', $order_id)->get();

    //         foreach($orderDetails as $order){

    //             $product_id = $order->product_id;
    //             $quantity = $order->quantity;
    //             $amount = $order->price;
    //             $invoice_id = $invoice->id;
    //             $total_amount = $quantity * $amount;
    //             $grose_total_amount += $total_amount;

    //             $product = Product::find($product_id);

    //             InvoiceDetails::create([
    //                 'product_id' => $product_id,
    //                 'invoice_id' => $invoice_id,
    //                 'quantity' => $quantity,
    //                 'amount' => $amount,
    //                 'total_amount' => $total_amount
    //                 ]);                
    //             $product->quantity = $product->quantity - $quantity;
    //             $product->save();  
    //         }

    //         $invoice->total_amount = $grose_total_amount;
    //         $invoice->save();


    //         // DB::commit();

    //         return $this->responseWithSuccess(true,'Invoice created successfully', 200);
           
    //     }
    //     catch(\Exception $e){
    //         // DB::rollBack();
    //         Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
    //         return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
    //     }
    // }


    public function store(Request $request)
    {

        $order_id = $request->order_id;
        $customer_id = $request->customer_id;
        $user = Auth::user();
        $invoice_date = date('Y-m-d H:i:s');
        $notes = '';

        $invoice_number = 'INV-'.date('Ymd').uniqid();

        $gross_total_amount = 0;

        $invoice = Invoice::create([
            'order_id'=> $order_id,
            'customer_id'=> $customer_id,
            'user_id'=> 2,
            'invoice_number'=> $invoice_number,
            'invoice_date'=> $invoice_date,
            'total_amount'=> 0,
            'status'=> "Pending",
        ]);




        $orderDetails = OrderDetails::where('order_id', $order_id)->get();

        $total_amount = 0;
        foreach($orderDetails as $order)
        {
            $product_id = $order->product_id;
            $quantity  = $order->quantity;
            $amount  = $order->price;

            $total_amount = $quantity * $amount;
            $gross_total_amount+= $total_amount;

            $invoiveDetails = [
                'invoice_id' =>  $invoice->id,
                'product_id' =>  $product_id,
                'quantity' =>  $quantity,
                'amount' =>  $amount,
                'total_amount' =>  $total_amount,
            ];

            InvoiceDetails::create($invoiveDetails);

            // update product table:
            $product = Product::find($product_id);
            $product->quantity = $product->quantity - $quantity;
            $product->save();
        }

        $invoice->total_amount = $gross_total_amount;
        $invoice->save();

        $order = Order::find($order->id);
        $order->status = 'confirmed';
        $order->save();

        return response()->json([
            'status' => 'success',
            'data' => $invoice,
            'message' => 'Invoice Created successfully.'
        ]);
    }


    public function show(Invoice $invoice)
    {
        try{
            return $this->responseWithSuccess('Invoice fetched successfully',new InvoiceResource($invoice) , 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }
    public function showInvoiceDetails(Invoice $invoice)
    {
        try{
            return $this->responseWithSuccess('Invoice fetched successfully',$invoice->InvoiceDetails(), 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }

    public function print(Invoice $invoice)
    {
        $pdf = Pdf::loadView('pdfs.invoice', compact('invoice'));
        return $pdf->stream('invoice.pdf');
        
    }
}
