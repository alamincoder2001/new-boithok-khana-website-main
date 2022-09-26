@extends('layouts.website')
@section('title','All Brand')
@section('website-content')

<!-- brand slider section start -->
<section class="py-md-4 py-5 mt-md-0 mt-4">
    <div class="container custom-container">
        <div class="product-title-part d-flex">
            <div class="my-auto">
                <h4 class="product-cat-title mb-2">Brand All</h4>
            </div>
        </div>
        <div class="row row-cols-md-5 row-cols-2 gx-2">
            @foreach($brand as $item)
            <div class="col"> <a href="{{ route('brandwise', $item->slug) }}"><img src="{{asset('/')}}{{ $item->image }}" alt=""></a></div>
            @endforeach
        </div>
    </div>
</section>
<!--  brand slider section end -->

@endsection
