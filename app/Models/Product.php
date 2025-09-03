<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','description','price','category_id','quantity','image'];

    public function getImageUrlAttribute(){
        return asset('storage/'.$this->image);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
