<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderWebsite extends Model
{
    use HasFactory;

    protected $table = "tbl_salesmaster";
    protected $primaryKey = "SaleMaster_SlNo";
    protected $filable = ['*'];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, "SalseCustomer_IDNo");
    }

    public function Orderdetails($id)
    {
        return OrderDetails::with("product")->where("order_retail", $id)->get();
    }
}
