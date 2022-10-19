<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = "tbl_saledetails";
    protected $fillable = ['*'];
    public $timestamps = false;
    public function product(){
    	return $this->belongsTo(Product::class, "Product_IDNo");
    }

}
