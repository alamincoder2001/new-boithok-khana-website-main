<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Ad;
use App\Models\Order;
use App\Models\Shape;
use App\Models\Banner;
use App\Models\Message;
use App\Models\Product;
use App\Models\Upazila;
use App\Models\Category;
use App\Models\Client;
use App\Models\Wishlist;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use App\Models\PublishedCategory;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(){

        $data["products"] = Product::where("status", "a")->where('is_website','true')->get();
        $data["banners"] = Banner::where('status','a')->latest()->get();
        $data["all"] = PublishedCategory::with(['published' => function($q){            
            $q->where('status',1);
            }])->where('status',1)->get();

        $data["after_product"] = Ad::where('status','a')->where('position','after_product')->first();
        $data["shapes"] = Shape::get();
        $data["clients"] = Client::get();
        return view('website.index', compact('data'));
      
    }

    public function categorywise($id){
        
        try {
            $products = Product::where("Status", "!=", "d")->where('is_website','true')->where('ProductCategory_ID', $id)->get();
            $category = Category::select('ProductCategory_Name')->where('ProductCategory_SlNo',$id)->first();
            $title = $category->ProductCategory_Name;
            return view('website.product.categorywise',compact('products', 'title'));
        } catch (\Throwable $th) {
            return view('website.error'); 
        }    
    }
    public function imagesWebsite(){
        $images = PhotoGallery::paginate(12);
        return view('website.pages.images',compact('images'));
        
    }
    public function shapeWebsite(){
        try {
            $data["shapes"] = Shape::get();
            return view('website.pages.shape', compact('data'));
        } catch (\Throwable $th) {
            return view('website.error'); 
        }
    }
    public function productDetails($id){

        try{
            $product  = Product::where('is_website','true')->where('Product_SlNo', $id)->first();
            if($product == []){
                return view('website.error');   
            }
            return view('website.productDetails',compact('product'));
        }
        catch(\Exception $e){
            return view('website.error'); 
        }
        
    }

    public function fetchUpazila($id){
        
        return $upazila = Upazila::where('district_id', $id)->get();
        // if(count($upazila)>0){
        //     $data = [];
        //     foreach($upazila as $item){
        //         $temp = '<option data-price="'.$item->charge_amount.'" value="'.$item->id.'">'.$item->name.'</option>';
        //         array_push($data, $temp);
        //     }
        //     return $data;
        // }
        // else{
        //     return false;
        // }
    }

    public function aboutWebsite()
    {
        return view('website.pages.about');
    }

    public function faq(){
        return view('website.pages.faq');
    }

    public function contact(){
        return view('website.pages.contact');
    }
    
    public function contactStore(Request $request){

        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' =>'required',
            'subject'=>'required',
            'message'=>'required'
        ]);

            try {
                $contact = new Message();
                $contact->sender_name = $request->name;
                $contact->phone = $request->phone;
                $contact->email = $request->email;
                $contact->subject = $request->subject;
                $contact->message = $request->message;
                $contact->ip_address = $request->ip();
                $contact->save();
                return redirect()->back()->with('success','Message successfully sent');                                   
            } catch (\Throwable $th) {
                return redirect()->back()->with('error','Message not sent!');
            }
            
        
    }

     public function customerWishList($id){

        try {
            if($id != 'all'){
                $products = Wishlist::with('product')->where('customer_id', $id)->get();
                return view('website.product.wishlist', compact('products'));
            }
            else{
                return redirect()->back()->with('error','Please Login First');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Something went wrong!');
        }
         
     }

     public function deleteWishList($id){

        try {
            $wishlist = Wishlist::find($id);
            $wishlist->delete();
            return redirect()->back()->with('success', 'Successfully Removed');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
        
     }

     public function wishCount(){
        if(Auth::guard('customer')->user()){
        $count = Wishlist::where('customer_id',Auth::guard('customer')->user()->id)->get();
        return count($count);
        }
        else{
            return 0;
        }
     }

    public function productSearch()
        {
            
            if (request()->query('q')) {
                $keyword = request()->query('q');
                $search_result = Product::where('is_website','true')->Where('name', 'like', "%$keyword%")->where('status','A')->get();
                return view('website.search', compact('search_result'));
            }
            return redirect()->back();
    }

    public function getSearchSuggestions($keyword){
            $product = Product::where('is_website','true')->select('name')
                ->where('name', 'like', "%$keyword%")->where('status','A')
                ->get()->toArray();
    
            $category = Category::select('name as name')
                ->where('name', 'like', "%$keyword%")
                ->get()->toArray();
    
            $subcategory = SubCategory::select('name as name')
                ->where('name', 'like', "%$keyword%")
                ->get()->toArray();
    
            $mergedArray = array_merge($product, $category, $subcategory);
    
            $search_results = [];
    
            foreach($mergedArray as $sr) {
                $search_results[] = $sr['name'];
            }
    
            return response()->json($search_results);
    }

    public function destroy($id){
        $order = Order::where("SaleMaster_SlNo",$id)->first();
        $order->Status = 'c';
        $order->UpdateBy = Auth::guard('customer')->user()->id;
        $order->save();
        return back()->with('success', 'Order cancel successfully');
    }

}
