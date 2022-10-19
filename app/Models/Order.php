<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    use HasFactory;
    protected $fillable  = ['*'];

    // customer relationship
    public function customer(){
    	return $this->belongsTo(Customer::class, 'customer_id');
    }
    // customer relationship
    public function Orderdetails($id)
    {
        return OrderDetails::with("product")->where("order_id", $id)->get();
    }
}
