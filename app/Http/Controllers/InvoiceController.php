<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\InvoiceResource;
use App\Http\Requests\InvoiceStoreRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
   use ApiResponse;
    public function store(InvoiceStoreRequest $request)
    {

        DB::beginTransaction();
        try{
            $customer_id = $request->customer_id;
            $user_id = $request->user_id;
            $invoice_number ='INV-'.uniqid();
            $invoice_date = $request->invoice_date;
            $notes = $request->notes;

            //product array
            $products = $request->products;
            $quantities = $request->quantity;
            $amounts = $request->amount;

            $grose_total_amount = 0;
            $total_amount = 0;

            foreach($products as $key => $value){
                $product_id = $products[$key];
                $quantity = $quantities[$key];
                $product = Product::find($product_id);
                if(!$product || $product->quantity < $quantity){
                    DB::rollBack();
                    return $this->responseWithError('Product quantity is not enough', [], 500);
                }
            }

            $invoice = Invoice::create([
                'customer_id' => $customer_id,
                'user_id' => $user_id,
                'invoice_number' => $invoice_number,
                'invoice_date' => $invoice_date,
                'total_amount' => 0,
                'notes' => $notes
            ]);

            foreach($products as $key => $value){

                $product_id = $products[$key];
                $quantity = $quantities[$key];
                $amount = $amounts[$key];
                $invoice_id = $invoice->id;
                $total_amount = $quantity * $amount;
                $grose_total_amount += $total_amount;

                $product = Product::find($product_id);

                InvoiceDetails::create([
                    'product_id' => $product_id,
                    'invoice_id' => $invoice_id,
                    'quantity' => $quantity,
                    'amount' => $amount,
                    'total_amount' => $total_amount
                    ]);                
                $product->quantity = $product->quantity - $quantity;
                $product->save();  
            }

            $invoice->total_amount = $grose_total_amount;
            $invoice->save();

            DB::commit();

            return $this->responseWithSuccess('Invoice created successfully', 200);
           
        }
        catch(\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
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
