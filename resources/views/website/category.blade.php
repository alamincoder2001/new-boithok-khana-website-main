@extends('layouts.website')
@section('website-content')

<!-- brand slider section start -->
<section class="py-md-4 py-5 mt-md-0 mt-4">
    <div class="container custom-container">
        <div class="product-title-part d-flex">
            <div class="my-auto">
                <h4 class="product-cat-title mb-2">Category All</h4>
            </div>
        </div>
        <div class="row row-cols-md-5 row-cols-2 g-2">
            @foreach($category as $item)
            <div class="col">
                <div class="right-cat-part-single d-flex">
                    <div class="name my-auto">
                        <h5>{{ $item->name }}</h5>
                        <a href="{{ route('categorywise',$item->slug) }}" class="form-control-sm bg-brand text-center text-white">Shop Now</a>
                    </div>
                    <div class="cat-image my-auto ms-auto">
                        <img src="{{asset('/')}}{{ $item->image }}" alt="">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!--  brand slider section end -->
@endsection
