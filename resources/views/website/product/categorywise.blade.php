@extends('layouts.website')
@section('title', "$title")
@section('website-content')

    <section class="my-4">
        <div class="container">
            <div class="row">
                <div class="col-auto me-auto">
                    <div class="common-title">Product of {{ $title }}</div>
                </div>
                <div class="col-auto">

                </div>
            </div>
            <hr class="mt-2">
            <div class="row row-cols-md-4 row-cols-1 gx-2">
                @forelse ($products as $item)
                    <div class="col explore-food">
                        <div class="card food_card">
                            <a href="{{ route('productDetails', $item->Product_SlNo) }}">
                                <img src="{{$domain}}uploads/products/{{$item->image}}" class="img-fluid w-100" alt="">
                            </a>
                            
                            <div class="p-3">
                                <h4 title="{{ $item->Product_Name }}" class="product-title">{{ Str::words($item->Product_Name, '2', '...') }}</h4>
                                <p class="p-0 m-0 product-info">৳ {{ $item->Product_SellingPrice }}</p>
                                            
                                <div class="food_btn d-flex justify-content-between">
                                    <div><a href=" {{ route('productDetails', $item->Product_SlNo) }}">View Details &nbsp;<i class="fa-solid fa-right-long"></i></a></div>
                                    <div class="btn btn-sm rounded-pill cart-btn" onclick="cartAjax({{ $item->Product_SlNo }})"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Add To Cart</div>
                                </div>
                            </div>                                        
                        </div>
                    </div>
                @empty
                    <h6 class="text-danger">Products Not Found</h6>
                @endforelse

            </div>
        </div>
    </section>

@endsection
