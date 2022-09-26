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
        if(Auth::guard('customer')->user()){
            if(\Cart::getContent()->count()>0){
                return view('website.customer.checkout',$data);  
            }
            else{
                return redirect()->back()->with('error','Your Cart is empty');
            }     
        }        
        if(!empty(session('otp_verify'))){
            if(session('otp_verify') == 'true'){
                if(\Cart::getContent()->count()>0){
                    return view('website.customer.checkout',$data); 
                }
                else{
                    return redirect()->back()->with('error','Your Cart is empty');
                }
                
            }
            else{               
                return redirect()->route('enter-phone.website');
            }            
        }
        else{
            return redirect()->route('enter-phone.website');
        }
        // return view('website.customer.login');
        // return view('website.customer.withoutlogin');  
    }
    
    public function checkoutStore(Request $request)
    {

        //dd($request->all());       
        if(isset($request->billDifferent)){

            $request->validate([
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
        }
        else{
            $request->validate([
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

        if(\Cart::getContent()->count()>0){
           
            $last_invoice_no =  Order::take(1)->pluck('SaleMaster_InvoiceNo');
            if(count($last_invoice_no) > 0){
                $invoice_no = $last_invoice_no[0] + 1;
            } else {
                $invoice_no = date('ymd') .'000001';
            }
    
            try {
                
                DB::beginTransaction();

                if(Auth::guard('customer')->check()){
                    $customerId = Auth::guard('customer')->user()->Customer_SlNo;
                }
                else{

                    $customer = new Customer();
                    if(Customer::where('Customer_Mobile',session('phone'))->exists()){    
                        $customerOldId = Customer::where('Customer_Mobile',session('phone'))->first();                 
                        $customerId = $customerOldId->Customer_SlNo;
                    }
                    else{
                        $customer->Customer_Code = 'C'. $this->generateCode('Customer');
                        $customer->Customer_Name = $request->customer_name;
                        $customer->Customer_Type = 'G';
                        $customer->customer_from = 'Website';
                        $customer->owner_name = 'Website';
                        $customer->Customer_Mobile = session('phone');
                        $customer->Customer_Email  = $request->customer_email;
                        $customer->username = '';
                        $customer->password = Hash::make(rand(100000,999999));
                        $customer->ip_address = $request->ip();
                        $customer->Customer_brunchid = 1;
                        $customer->save(); 
                        $customerId = $customer->Customer_SlNo;
                    }                  
                }
                $order = new Order();
                $order->SaleMaster_InvoiceNo= $invoice_no;
                $order->SalseCustomer_IDNo  = $customerId;
                $order->district_id         = $request->district_id;
                $order->upazila_id          = $request->upazila_id;
                $order->SaleMaster_SaleDate = date("Y-m-d");
                $order->cus_message         = $request->cus_message;
                $order->shipping_address    = $request->shipping_address;
                $order->billing_address     = $request->billing_address; 
                $order->SaleMaster_TotalDiscountAmount = 0.00; 
                $order->SaleMaster_TaxAmount       = 0.00; 
                $order->SaleMaster_SubTotalAmount  = \Cart::getTotal(); 
                $order->SaleMaster_PaidAmount      = \Cart::getTotal() + $request->charge; 
                $order->SaleMaster_DueAmount       = 0.00; 
                $order->bname               = $request->bname;
                $order->bphone               = $request->bphone;                
                $order->shipping_cost       = $request->charge;
                $order->sale_from           = 'Website';
                $order->AddTime             = date("Y-m-d H:i:s");
                $order->SaleMaster_branchid = 1;
                $order->payment_type        = 'Cash';
                $order->Status              = 'p';
                $order->ip_address          = $request->ip();
                $order->SaleMaster_TotalSaleAmount  = \Cart::getTotal() + $request->charge;
                $order->save();
                
                foreach (\Cart::getContent() as $value){
                    
                    $price = ($value->price * $value->quantity);
                    $orderDetails = new OrderDetails();                   
                    $orderDetails->SaleMaster_IDNo = $order->id;
                    $orderDetails->Product_IDNo = $value->id;
                    $orderDetails->SaleDetails_TotalQuantity = $value->quantity;
                    $orderDetails->SaleDetails_Rate =$value->price;
                    $orderDetails->SaleDetails_Discount = 0.00;
                    $orderDetails->SaleDetails_Tax = 0.00;
                    $orderDetails->SaleDetails_TotalAmount = $price;
                    $orderDetails->Status  = 'p';
                    $orderDetails->AddTime = date("Y-m-d H:i:s");                                      
                    $orderDetails->SaleDetails_BranchId = 1;                    
                    $orderDetails->save();
                }
                DB::commit();           
                \Cart::clear();
                Session::forget(['phone', 'otp_verify', 'otp_no']);

                $order = Order::where('SaleMaster_SlNo', $order->id)->first();
                return view('website.customer.orderInvoice', compact('order'));

                return redirect()->route('home')->with('success', 'order Submit successfully');
            } catch (\Throwable $th) {
                return $th->getMessage();
                return redirect()->back()->with('error', 'order submitted fail!');
            }
           
        }
        else {
            return redirect()->route('home'); 
        }
    }  
}
