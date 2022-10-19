<?php

namespace App\Http\Controllers\Customer;

use App\Models\Order;
use App\Models\Country;
use App\Models\Upazila;
use App\Models\Customer;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        // return $this->middleware('customerCheck');
    }
    public function dashboard()
    {

        if(Auth::guard('customer')->check()){
            $data['districts'] = District::all();
            $data['upazilas'] = Upazila::all();
            $data['orders'] = Order::with('customer')->where("sale_from", 'website')->where('SalseCustomer_IDNo', Auth::guard('customer')->user()->Customer_SlNo)->where("Status", "!=", "d")->get();
            return view('website.customer.dashboard', $data);
        }
        else{
            return redirect()->route('customer.login');
        }
    }

    public function customerUpdate(Request $request)
    {       
        $this->validate($request, [
            'name'        => 'required|max:70',
            'phone'       => 'required|max:11',
            'email'       => 'max:50',
            'username'    => 'required|max:50',
            'ip_address'  => 'max:17',
            'password'  => 'required|string|same:cpassword|min:1'
        ]);
      
        try{
            DB::beginTransaction();
            $customer = Customer::where('Customer_SlNo', auth()->guard('customer')->user()->Customer_SlNo)->first();
            
            if ($request->hasFile("profile_picture")) {
                if($customer->profile_picture != null){
                    $imagePath = './uploads/customer/' . $customer->profile_picture;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $image             = $request->file('profile_picture');
                $profile_picture   = Auth::guard('customer')->user()->Customer_Phone . uniqid() . '.' . $image->getClientOriginalExtension();               
                Image::make($image)->save('uploads/customer/' . $profile_picture);
            }
            else{
                $profile_picture = $customer->image_name;              
            }
            $customer->Customer_Name            = $request->name;
            $customer->Customer_Email           = $request->email;
            $customer->Customer_Phone           = $request->phone;
            $customer->Customer_Mobile          = $request->phone;
            $customer->username                 = $request->phone;
            if($request->password){
                $customer->password        = Hash::make($request->password);
            }
            $customer->profile_picture = $profile_picture;
            $customer->save();
            DB::commit();
            return redirect()->back()->with('success', 'Successfully Updated');
        }
        catch(\Exception $c){
            DB::rollBack();
            return $c->getMessage();
            return redirect()->back()->with('error', 'Updated Failed');
        }
    }

    public function addressChange(Request $request){
        $request->validate([
            'district_id'  =>'required',
            'address'      =>'required',
        ]);

        try {
            if(Auth::guard('customer')->check()){
                $customer = Customer::where('Customer_SlNo',Auth::guard('customer')->user()->Customer_SlNo)->first();
                $customer->area_ID = $request->district_id;
                $customer->Customer_Address  = $request->address;
                $customer->save();
                return back()->with('success','address updated successfully');
            }
            else{
                return redirect()->route('customer.login');
            }
        } catch (\Throwable $th) {
            return redirect()->route('customer.dashboard');
        }

    }
}
