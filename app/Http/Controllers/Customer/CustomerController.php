<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{

    public function customer()
    {
        if (Auth::guard('customer')->check()) {
            Session::flash('message', 'You have already login');
            return redirect()->route('customer.dashboard');
        } else {
            return view('website.customer.login');
        }
    }
    public function quickOrder(Request $request){
        $request->validate([
            'phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'name'=> 'required|min:3|max:50',
            'address'=> 'required|max:150'
        ]);

        $request->session()->put('name',$request->name);  
        $request->session()->put('phone',$request->phone);  
        $request->session()->put('address',$request->address);          
        // $request->session()->put('otp_verify','false'); 

        return redirect()->route('checkout');
    }
    public function enterPhone(){
        return view('website.customer.withoutlogin');
    }

    public function sendOTP(Request $request){
        $request->validate([
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11'
        ]);
        $phone = $request->phone;        
        $request->session()->put('phone',$phone);
        $otp = rand(100000,999999);
        $request->session()->put('otp_no',$otp);  
        $request->session()->put('otp_verify','false');  

        if(empty(session('name'))){
            $request->session()->put('name',''); 
            $request->session()->put('phone','');  
            $request->session()->put('address','');
        }
         
        // $otp = rand(100000, 999999);
        // $wlogin = session()->get('wlogin', []);
        // $wlogin[$phone] = [
        //     "verify" => 'false',
        //     "otp" => $otp,
        // ];
        // session()->put('wlogin', $wlogin);

        return redirect()->route('send-otp-pin'); 
    }

    public function otpPage(){
        return view('website.customer.otp');
    }

    public function otpVerify(Request $request){
        $request->validate([
            'otp' => 'required|digits:6'
        ]);
        
        $main_otp = $request->session()->get('otp_no');
        if($main_otp == $request->otp){      
            $request->session()->put('otp_verify','true');
            return redirect()->route('checkout');
        }
        else{
            return back()->with('failed', 'Your OTP Not Matched!');
        }
    }
    

    public function AuthCheck(Request $request)
    {
        $request->validate([
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|max:11',
            'password' => 'required|min:1'
        ]);
        try {

            // $credential = $request->only('password');
            $credential['username'] = $request->phone;
            $credential['password'] = $request->password;
            if(Auth::guard('customer')->attempt($credential)){
               return redirect()->route('customer.dashboard');
            }else{
                return redirect()->back()->with('error', 'Mobile No or Password Incorrect !');
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Mobile No or Password  !');
        }
    }

    public function signUp()
    {
        if (Auth::guard('customer')->check()) {
            Session::flash('message', 'You have already login');
            return redirect()->route('checkout.user');
        } else {
            return view('website.customer.signup');
        }
    }


    public function customerForm()
    {
        return view('website.customer.signup');
    }

    public function customerStore(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:100',
            'phone' => 'required|regex:/^01[13-9][\d]{8}$/|min:11',
            'password' => 'required|string|same:cpassword|min:1',
            'ip_address' => 'max:15'
        ]);

       try {

            $customer = new Customer();
            $customer->Customer_Code = 'C'. $this->generateCode('Customer');
            $customer->Customer_Name = $request->name;
            $customer->Customer_Phone = $request->phone;
            $customer->Customer_Mobile = $request->phone;
            $customer->username        = $request->phone;
            $customer->Customer_Type = 'retail';
            $customer->owner_name = ' ';
            $customer->password = Hash::make($request->password); 
            $customer->Customer_brunchid  = 1;
            $customer->save();           
        return redirect()->route('customer.login')->with('success','Account created successfully');

       } catch (\Throwable $th) {
            return $th->getMessage();
           return back()->with('error','Account created fail!');
       }
       
    }


    public function customerPasswordUpdate(Request $request)
    {

        if (Auth::guard('customer')->check()) {
            $request->validate([
                'currentPass' => 'required',
                'password' => 'required|min:4|same:confirmed',
            ]);
            
            $currentPassword = Auth::guard('customer')->user()->password;
            if (Hash::check($request->currentPass, $currentPassword)) {
                if (!Hash::check($request->password, $currentPassword)) {
                    $customer = Customer::find(Auth::guard('customer')->id());
                    $customer->password = HasH::make($request->password);
                    $customer->save();
                    if ($customer) {
                        Session::flash('message', 'Password Update Successfully');
                        return back();
                    } else {
                        Session::flash('error', 'Current password not match');
                        return back();
                    }
                } else {
                    Session::flash('error', 'Same as Current password');
                    return back();
                }
            } else {
                Session::flash('error', '!Current password not match');
                return back();
            }
        } else {
            return view('website.customer.login');
        } 
    }

    public function customerPanel()
    {
        if (Auth::guard('customer')->check()) {
            $order = Order::with('Orderdetails')->where('Customer_SlNo', Auth::guard('customer')->user()->Customer_SlNo)->latest()->get();
            return view('website.customer.dashboard', compact('order'));
        } else {
            return redirect()->route('home');
        }
    }

    public function customerInvoice($id){
        if (Auth::guard('customer')->check()) {
            if(Order::with("Orderdetails")->where('SaleMaster_SlNo', $id)->where('SalseCustomer_IDNo', Auth::guard('customer')->user()->Customer_SlNo)->exists()){
                $order = Order::where('SaleMaster_SlNo', $id)->first();
            }
            else{
                Session::flash('error', 'Invoice not found!');
                return redirect()->route('customer.dashboard'); 
            }           
            return view('website.customer.invoice', compact('order'));
        } else {
            return redirect()->route('customer.login');
        }      
    }

    public function logout()
    {
        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->logout();
            Session::flash('error', 'Logout Successfully');
            return redirect()->route('home');
        } else {
            return redirect()->route('customer.login');
        }
    }
}
