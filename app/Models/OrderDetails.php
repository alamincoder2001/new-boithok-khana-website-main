<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $table = "tbl_saledetails";
    protected $fillable = ['*'];
    
    public function order(){
    	return $this->belongsTo(Order::class, 'SaleMaster_IDNo', 'SaleMaster_SlNo');
    }

    public function product(){
    	return $this->belongsTo(Product::class, 'Product_IDNo', 'Product_SlNo');
    }

}
