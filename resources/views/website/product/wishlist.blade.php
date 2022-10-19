@extends('layouts.website')
@section('title', 'Wish List')
@section('website-content')

    <section class="pt-5">
        <div class="container-fluid custom-container border-bottom-custom">
            <div class="row">
                <div class="col-auto me-auto">
                    <div class="common-title">Product of Wishlist</div>
                </div>
                <div class="col-auto">

                </div>
            </div>
            <hr class="mt-2">
            <div class="row row-cols-5 row-cols-1 gx-0">
                @foreach ($products as $item)
                    @if($item->product != '')
                    <div class="col">
                        <div class="product-colum shadow-sm p-3 rounded">
                            <a href="{{ route('productDetails', optional($item->product)->Product_SlNo) }}">
                                <div class="center"><img class="product-image" src="{{$domain}}uploads/products/{{$item->image }}"
                                        alt=""></div>
                                <div class="product-title text-center pt-2">
                                    <p>{{ optional($item->product)->Product_Name }}</p>
                                </div>

                                <div class="mt-2 text-center">
                                    <p class="text-dark text-center">৳ {{ optional($item->product)->Product_SellingPrice }}</p>
                                </div>

                                <div class="product_fav">
                                    <a href="{{ route('delete.wishlist', $item->id) }}"><i
                                            class="fas fa-trash customize-icon-heart" style="cursor:pointer"></i></a>
                                    <i class="fa-solid fa-eye  customize-icons-eye"></i>
                                </div>
                                <div class="product_cart_button"
                                    onclick="cartAjax({{ optional($item->product)->Product_SlNo }})">Add To Cart</div>
                                <div>
                                    <a class="new-product" href="#">New</a>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                @endforeach

            </div>
        </div>
    </section>

@endsection
