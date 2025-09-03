<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Traits\ApiResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Cache\Store;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

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

             if($request->expectsJson()){

            }else{
                flash()
                ->option('position', 'bottom-left')
                ->success('Product updated successfully!');
                return redirect('backend/admin/products/list');
            }

            return $this->responseWithSuccess('Product updated successfully', 200);
        }

        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
        }
    }

    public function adminProductList(){
       try{
            $products = Product::orderBy('name', 'asc')->get();
            return view('pages.dashboard.admin.products.list', compact('products')); 
       }

       catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
       }
    }
    public function adminProductEdit(Product $product){
       try{
            $categories = Category::orderBy('name', 'asc')->get();
            return view('pages.dashboard.admin.products.edit', compact('product','categories')); 
       }

       catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError('Something went wrong. Please try again.', [], 500);
       }
    }
    
}
