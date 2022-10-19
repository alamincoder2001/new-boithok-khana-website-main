<?php

namespace App\Http\Controllers\Customer;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\Customer;
use App\Models\District;
use Darryldecode\Cart\Cart;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderWebsite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $data['countries'] = Country::all();
        $data['districts'] = District::all();
        $data['upazilas'] = Upazila::all();
        if (Auth::guard('customer')->user()) {
            if (\Cart::getContent()->count() > 0) {
                return view('website.customer.checkout', $data);
            } else {
                return redirect()->back()->with('error', 'Your Cart is empty');
            }
        }
        // if (!empty(session('otp_verify'))) {
        //     if (session('otp_verify') == 'true') {
                if (\Cart::getContent()->count() > 0) {
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

        // dd($request->all());       
        if (isset($request->billDifferent)) {

            $request->validate(
                [
                    'customer_name'     => 'required|max:150',
                    'customer_mobile'   => 'required|max:11',
                    'district_id'       => 'required',
                    'upazila_id'        => 'required',
                    'shipping_address'  => 'required',
                    'billing_address'  => 'required',
                    'charge'            => 'required',
                    'bname'             => 'required',
                    'bphone'            => 'required'
                ],
                [
                    'district_id.required'       => 'District must be fill-up',
                    'upazila_id.required'        => 'Upazila must be fill-up',
                    'customer_name.required'     => 'Name must be fill-up',
                    'customer_mobile.required'   => 'Phone must be fill-up',
                    'customer_mobile.max'        => 'Phone No. maximum 11 Number',
                    'shipping_address.required'  => 'Shipping Address must be fill-up',
                    'billing_address.required'   => 'Billing Address must be fill-up',
                    'charge.required'            => 'Charge Fill Must be fill-up',
                    'bname.required'             => 'Biller Name Fill Must be fill-up',
                    'bphone.required'            => 'Biller Phone Fill Must be fill-up'
                ]
            );
        } else {
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
        }

        if (\Cart::getContent()->count() > 0) {

            $last_invoice_no =  Order::take(1)->pluck('invoice_no');
            if (count($last_invoice_no) > 0) {
                $invoice_no = $last_invoice_no[0] + 1;
            } else {
                $invoice_no = date('ymd') . '000001';
            }

            try {
                DB::beginTransaction();
                $ordermain = new OrderWebsite();
                $order = new Order();
                if (Auth::guard('customer')->check()) {
                    $customerId = Auth::guard('customer')->user()->id;
                    $customerOldId = Auth::guard('customer')->user();
                    $ordermain->Customer_name = $customerOldId->name;
                    $ordermain->Customer_phone = $customerOldId->phone;
                    $ordermain->Customer_email  = $customerOldId->email;
                } else {
                    $customer = new Customer();
                    if (Customer::where('phone', session('phone'))->exists()) {
                        $customerOldId = Customer::where('phone', session('phone'))->first();
                        $customerId = $customerOldId->id;
                        $ordermain->Customer_name = $customerOldId->name;
                        $ordermain->Customer_phone = $customerOldId->phone;
                        $ordermain->Customer_email  = $customerOldId->email;
                    } else {
                        $order->customer_name = $request->customer_name;
                        $order->customer_type = 'G';
                        $order->customer_phone = $request->customer_mobile;
                        $order->customer_email  = $request->customer_email;

                        $ordermain->Customer_name = $request->customer_name;
                        $ordermain->Customer_phone = $request->customer_mobile;
                        $ordermain->Customer_email  = $request->customer_email;
                    }
                }

                $order->invoice_no = $invoice_no;
                if (isset($customerId)) {
                    $order->customer_id  = $customerId;
                }
                $order->district_id         = $request->district_id;
                $order->upazila_id          = $request->upazila_id;
                $order->sale_date           = date("Y-m-d");
                $order->cus_message         = $request->cus_message;
                $order->shipping_address    = $request->shipping_address;
                $order->billing_address     = $request->billing_address;
                $order->total_amount        = \Cart::getTotal();
                $order->bname               = $request->bname;
                $order->bphone              = $request->bphone;
                $order->shipping_cost       = $request->charge;
                $order->payment_type        = "Cash";
                $order->status              = 'p';
                $order->ip_address          = $request->ip();
                $order->save();

                // retail software
                $ordermain->SaleMaster_InvoiceNo = $invoice_no;
                if (isset($customerId)) {
                    $ordermain->SalseCustomer_IDNo = $customerId;
                }
                $ordermain->SaleMaster_TotalDiscountAmount = 0.00;
                $ordermain->SaleMaster_SaleDate = date("Y-m-d");
                $ordermain->SaleMaster_SaleType = "Website";
                $ordermain->payment_type = "Cash";
                $ordermain->SaleMaster_SubTotalAmount  = \Cart::getTotal();
                $ordermain->SaleMaster_TotalSaleAmount  = \Cart::getTotal() + $request->charge;
                $ordermain->SaleMaster_TaxAmount       = 0.00;
                $ordermain->SaleMaster_PaidAmount      = \Cart::getTotal() + $request->charge;
                $ordermain->SaleMaster_DueAmount       = 0.00;
                $ordermain->SaleMaster_TotalDiscountAmount = 0.00;
                $ordermain->SaleMaster_Freight = 0.00;
                $ordermain->SaleMaster_Previous_Due = 0.00;
                $ordermain->shipping_cost = $request->charge;
                $ordermain->SaleMaster_branchid = 1;
                $ordermain->Status = "p";
                $ordermain->Customer_message = $request->cus_message;

                $ordermain->save();



                foreach (\Cart::getContent() as $value) {

                    $price = ($value->price * $value->quantity);
                    $orderDetails = new OrderDetails();
                    $orderDetails->order_retail = $ordermain->SaleMaster_SlNo;
                    $orderDetails->order_id = $order->id;
                    $orderDetails->product_id = $value->id;
                    $orderDetails->quantity = $value->quantity;
                    $orderDetails->price = $price;
                    $orderDetails->save();
                }
                DB::commit();
                \Cart::clear();
                // Session::forget(['phone', 'otp_verify', 'otp_no']);

                $orders = Order::with("customer")->where('id', $order->id)->first();
                return view('website.customer.orderInvoice', compact('orders'));

                return redirect()->route('home')->with('success', 'order Submit successfully');
            } catch (\Throwable $th) {
                return $th->getMessage();
                return redirect()->back()->with('error', 'order submitted fail!');
            }
        } else {
            return redirect()->route('home');
        }
    }
}
