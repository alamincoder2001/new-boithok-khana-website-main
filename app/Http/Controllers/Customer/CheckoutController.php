<?php

namespace App\Http\Controllers\Customer;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Upazila;
use App\Models\Customer;
use App\Models\District;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $data['districts'] = District::where("status", "a")->orderBy("District_Name")->get();
        $data['upazilas'] = Upazila::all();
        if (Auth::guard('customer')->user() || session()->get('phone')) {
            if (\Cart::getContent()->count() > 0) {
                return view('website.customer.checkout', $data);
            } else {
                return redirect()->back()->with('error', 'Your Cart is empty');
            }
        } else {
            return back()->with('error', 'Must be login or quick order');
        }
        // if (!empty(session('otp_verify'))) {
        //     if (session('otp_verify') == 'true') {
        if (\Cart::getContent()->count() != 0) {
            return view('website.customer.checkout', $data);
        } else {
            return redirect()->back()->with('error', 'Your Cart is empty');
        }
        //     } else {
        //         return redirect()->route('enter-phone.website');
        //     }
        // } else {
        //     return redirect()->route('enter-phone.website');
        // }
        // return view('website.customer.login');
        // return view('website.customer.withoutlogin');  
    }

    public function checkoutStore(Request $request)
    {

        $request->validate(
            [
                'customer_name'     => 'required|max:150',
                'customer_mobile'   => 'required|max:11',
                'district_id'       => 'required',
                'upazila_id'        => 'required',
                'shipping_address'  => 'required',
                'charge'            => 'required',
            ],
            [
                'district_id.required'       => 'District must be fill-up',
                'upazila_id.required'        => 'Upazila must be fill-up',
                'customer_name.required'     => 'Name must be fill-up',
                'customer_mobile.required'   => 'Phone must be fill-up',
                'customer_mobile.max'        => 'Phone No. maximum 11 Number',
                'shipping_address.required'  => 'Shipping Address must be fill-up',
                'charge.required'            => 'Charge Fill Must be fill-up',
            ]
        );

        if (\Cart::getContent()->count() > 0) {
            try {
                DB::beginTransaction();
                $last_invoice_no =  Order::first();
                if (!empty($last_invoice_no)) {
                    $invoice_no = $last_invoice_no->SaleMaster_InvoiceNo + 1;
                } else {
                    $invoice_no = date('y') . '0100001';
                }
                
                if (Auth::guard('customer')->check()) {
                    $customerId = Auth::guard('customer')->user()->Customer_SlNo;
                } else {
                    $customer = new Customer;
                    $customer->Customer_Code = 'C' . $this->generateCode('Customer');
                    $customer->Customer_Type = 'G';
                    $customer->Customer_Name = $request->customer_name;
                    $customer->Customer_Phone = $request->customer_mobile;
                    $customer->Customer_Mobile = $request->customer_mobile;
                    $customer->Customer_Email  = $request->customer_email;
                    $customer->Customer_Address  = session("address");
                    $customer->save();
                    $customerId = $customer->Customer_SlNo;
                }

                // retail software
                $order = new Order();
                $order->SaleMaster_InvoiceNo = $invoice_no;
                $order->SalseCustomer_IDNo = $customerId;
                $order->SaleMaster_TotalDiscountAmount = 0.00;
                $order->SaleMaster_SaleDate = date("Y-m-d");
                $order->SaleMaster_SaleType = "retail";
                $order->payment_type = "Cash";
                $order->SaleMaster_SubTotalAmount  = \Cart::getTotal();
                $order->SaleMaster_TotalSaleAmount  = \Cart::getTotal() + $request->charge;
                $order->SaleMaster_TaxAmount       = 0.00;
                $order->SaleMaster_PaidAmount      = \Cart::getTotal() + $request->charge;
                $order->SaleMaster_DueAmount       = 0.00;
                $order->SaleMaster_TotalDiscountAmount = 0.00;
                $order->SaleMaster_Previous_Due = 0.00;
                $order->SaleMaster_Freight = $request->charge;
                $order->SaleMaster_branchid = 1;
                $order->Status = "p";
                $order->sale_from = "website";
                $order->Customer_message = $request->cus_message;
                
                $order->shipping_address = $request->shipping_address;
                $order->billing_address = $request->billing_address;


                $order->save();

                foreach (\Cart::getContent() as $value) {

                    $price = ($value->price * $value->quantity);
                    $mainDetails = new OrderDetails();
                    $mainDetails->SaleMaster_IDNo = $order->SaleMaster_SlNo;
                    $mainDetails->Product_IDNo  = $value->id;
                    $mainDetails->SaleDetails_TotalQuantity = $value->quantity;
                    $mainDetails->SaleDetails_Rate = $value->price;
                    $mainDetails->SaleDetails_TotalAmount = $price;
                    $mainDetails->Status = "a";
                    $mainDetails->AddTime = Carbon::now();
                    $mainDetails->SaleDetails_BranchId = "1";
                    $mainDetails->save();
                }
                DB::commit();
                \Cart::clear();
                Session::forget(['phone', 'name', 'address']);

                $orders = Order::with("customer")->where('SaleMaster_SlNo', $order->SaleMaster_SlNo)->first();
                return view('website.customer.orderInvoice', compact('orders'));

            } catch (\Throwable $th) {
                return $th->getMessage();
                return redirect()->back()->with('error', 'order submitted fail!');
            }
        } else {
            return redirect()->route('home');
        }
    }
}
