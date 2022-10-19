<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    protected $table = "tbl_product";
    protected $primaryKey = "Product_SlNo";
    protected $filable =['*'];

  
}
