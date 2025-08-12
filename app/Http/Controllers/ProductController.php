<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ApiResponse;

    public function index(){

       try{
            $products = Product::all();
            return $this->responseWithSuccess('Products fetched successfully',ProductResource::collection($products), 200);
       }

       catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
       }
        
    }
    public function store(ProductStoreRequest $request){

        try{
            $data = $request->validated();

            if($request->hasFile('image')){
                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
            }
            
            $product = Product::create($data);
            return $this->responseWithSuccess('Product created successfully',new ProductResource($product), 201);
        }

        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }

    }
    public function show(Product $product){
        try{
            return $this->responseWithSuccess('Product fetched successfully',new ProductResource($product), 200);
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }

    }
    public function update(ProductUpdateRequest $request, Product $product){

        try{
            $data = $request->validated();

            if($request->hasFile('image')){
                Storage::disk('public')->delete($product->image);
                $path = $request->file('image')->store('products', 'public');
                $data['image'] = $path;
            }

            $product->update($data);
            return $this->responseWithSuccess('Product updated successfully', 200);
        }

        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }

    }
}
