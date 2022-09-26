<?php

namespace App\Models;


use App\Models\ProductPublished;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublishedCategory extends Model
{
    use HasFactory;
    protected $fillable = ["*"];

    public function published(){
        return $this->hasMany(ProductPublished::class,'published_category_id','id')->with('product');
    }
    
}
