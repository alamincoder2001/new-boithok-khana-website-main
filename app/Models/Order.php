<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class Order extends Model
{
    use HasFactory;
    protected $table = "tbl_salesmaster";
    protected $primaryKey = "SaleMaster_SlNo";
    protected $fillable = ['*'];
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, "SalseCustomer_IDNo");
    }

    public function Orderdetails($id)
    {
        return OrderDetails::where("SaleMaster_IDNo", $id)->get();
    }
}
