<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Inventory;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{

    public function cartList()
    {
        $cartItems = \Cart::getContent();
        return view('website.cart', compact('cartItems'));
    }

    public function addtocart(Request $request)
    {
        //   try {
        //     $id = $request->txtId;
        //     $product = Product::where('Product_SlNo',$id)->first();
        //     \Cart::add([
        //         'id' => $id,
        //         'name' =>$product->Product_Name,
        //         'price' => $product->Product_SellingPrice,
        //         'quantity' => $request->quantity,
        //         'attributes' => array(
        //             'image' => 'http://kssoft.expressretailbd.com/uploads/products/'.$product->image,
        //         )
        //         ]);  
        //     Session::flash('success', 'Cart Added Successfully');
        //     return redirect()->back();
        //   } catch (\Throwable $th) {
        //     Session::flash('error', 'Cart Added Failed');
        //     return redirect()->back();
        //   }


        try {
            $id = $request->txtId;
            $product = Product::where('Product_SlNo', $id)->first();
            \Cart::add([
                'id' => $id,
                'name' => $product->Product_Name,
                'price' => $product->Product_SellingPrice,
                'quantity' => $request->quantity,
                'attributes' => array(
                    'image' => "http://localhost:84/uploads/products/" . $product->image,
                )
            ]);
            return response()->json([
                'result' => 'true',
                'cart'   => \Cart::getContent()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'result' => 'false'
            ]);
        }
    }

    public function cartAjax(Request $request, $id)
    {
        $product = Product::where('Product_SlNo', $id)->first();

        \Cart::add([
            'id' => $id,
            'name' => $product->Product_Name,
            'price' => $product->Product_SellingPrice,
            'quantity' => 1,
            'attributes' => array(
                'image' => "http://localhost:84/uploads/products/" . $product->image,
            )
        ]);

        return response()->json([
            'total_amount' => \Cart::getTotal(),
            'total_item'   => \Cart::getContent()->count(),
            'cart'         => \Cart::getContent()
        ]);
    }

    public function cartDetails()
    {

        return response()->json([
            'total_amount' => \Cart::getTotal(),
            'total_item'   => \Cart::getContent()->count(),
            'cart'         => \Cart::getContent()
        ]);
    }

    public function cartShipping()
    {

        return response()->json([
            'total_amount' => \Cart::getTotal(),
            'total_item'   => \Cart::getContent()->count(),
            'cart'         => \Cart::getContent()
        ]);
    }

    public function cartRemove($id)
    {
        \Cart::remove($id);
        return true;
    }

    public function cartIncrement($id)
    {

        $product = Product::where('Product_SlNo', $id)->first();
        foreach (\Cart::getContent() as $item) {
            if ($item->id == $product->Product_SlNo) {
                if ($item->quantity + 1 <= 1000) {
                    if ($item->id == $product->Product_SlNo) {
                        \Cart::update(
                            $item->id,
                            [
                                'quantity' => [
                                    'relative' => false,
                                    'value' => $item->quantity + 1
                                ],
                            ]
                        );
                        $cartItem = \Cart::getContent();
                        return response()->json([
                            'cartItem'     => $cartItem,
                            'item'         => $item,
                            'total_amount' => \Cart::getTotal(),
                            'total_item'   => \Cart::getContent()->count()
                        ]);
                    }
                } else {
                    return response()->json(['error' => 'out']);
                }
            }
        }
    }

    public function cartDecrement($id)
    {
        $product = Product::where('Product_SlNo', $id)->first();
        foreach (\Cart::getContent() as $item) {
            if ($item->id == $product->Product_SlNo) {
                if ($item->quantity == 1) {
                    $cart = 'data updated successfully';
                } else {
                    \Cart::update(
                        $item->id,
                        [
                            'quantity' => [
                                'relative' => false,
                                'value' => $item->quantity - 1,
                            ],
                        ]
                    );
                }
            }
        }

        $cartItem = \Cart::getContent();
        return response()->json([
            'cartItem'     => $cartItem,
            'item'         => $item,
            'total_amount' => \Cart::getTotal(),
            'total_item'   => \Cart::getContent()->count()
        ]);
    }

    public function cartRemoveSelected(Request $request)
    {

        $data = $request->cartChecked;

        foreach ($data as $item) {
            \Cart::remove($item);
        }

        return true;
    }

    public function wishlist($id)
    {

        if (Auth::guard('customer')->user()) {

            $wishlist = new Wishlist();
            $wishlist->customer_id = Auth::guard('customer')->user()->id;
            $wishlist->product_id = $id;
            $count = Wishlist::where('customer_id', Auth::guard('customer')->user()->id)->get();
            if (Wishlist::where('customer_id', Auth::guard('customer')->user()->id)->where('product_id', $id)->exists()) {

                return response()->json([
                    'wishlist' => count($count),
                    'result' => 'exists'
                ]);
            } else {
                $wishlist->save();
                return response()->json([
                    'wishlist' => count($count) + 1,
                    'result' => 'true'
                ]);
            }
        } else {
            return response()->json([
                'wishlist' => 0,
                'result' => 'false'
            ]);
        }
    }
}
