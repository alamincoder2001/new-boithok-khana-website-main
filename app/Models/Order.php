<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    use HasFactory;
    protected $table = "tbl_salesmaster";
    protected $fillable  = ['*'];

    // customer relationship
    public function customer(){
    	return $this->belongsTo(Customer::class, 'SalseCustomer_IDNo', 'Customer_SlNo');
    }
    // customer relationship
    public function orderDetails(){
    	return $this->hasMany(OrderDetails::class, 'SaleMaster_IDNo', 'SaleMaster_SlNo')->with('product');
    }
}
