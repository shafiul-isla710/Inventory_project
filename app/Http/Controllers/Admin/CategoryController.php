<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiResponse;
    public function adminCategoryList(){
        try{
            $categories = Category::orderBy('name', 'asc')->paginate(5);
            return view('pages.dashboard.admin.category.index', compact('categories'));
        }
        catch(\Exception $e){
            Log::error($e->getMessage().''.$e->getFile().':'.$e->getLine());
            return $this->responseWithError(false,'Something went wrong. Please try again.', [], 500);
        }
    }
}
