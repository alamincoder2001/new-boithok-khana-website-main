@extends('layouts.website')
@section('title', $product->Product_Name)
@push('website-css')
   <!-- product zoom -->
   <link rel="stylesheet" href="{{ asset('website/cssb/slick.css')}}">
   <link rel="stylesheet" href="{{ asset('website/cssb/slick-theme.css')}}">
   <link rel="stylesheet" href="{{ asset('website/cssb/swiper.min.css')}}" />
   <link rel="stylesheet" href="{{ asset('website/cssb/easyzoom.css')}}" />
   <link rel="stylesheet" href="{{ asset('website/cssb/main.css')}}" />
   <!-- close product view --> 
   <style>
     table{
       width: 100%;
       border: 1px solid #B4B5B6;     
     }
     td{
      border: 1px solid #B4B5B6; 
      padding:2px 5px;
     }

     .tab-pane img{
      width: 100%;
      height: auto;
     }
     ul{
         padding-left: 0px !important
     }
     .nav-tabs-bordered li .active {
        background-color: #f79637 !important;
        border-radius: 0px;
        color: #FFFFFF !important;
    }
    .nav-link {
        color:unset
    }
   </style>
@endpush
@section('website-content')

<!-- product details -->
<section class="py-2">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-12">
        <!-- multiple product image view -->
         <div class="product__carousel">
          <div class="gallery-parent">
            <div class="swiper-container gallery-top">
              <div class="swiper-wrapper">                          
                 <div class="swiper-slide easyzoom easyzoom--overlay">
                      <a href="{{$domain}}uploads/products/{{ $product->image }}">
                      <img width="50" src="{{$domain}}uploads/products/{{ $product->image }}" alt="" />
                      </a>
                  </div>                                        
              </div>
            </div>
  
            <div class="swiper-container gallery-thumbs">
              <div class="swiper-wrapper">
                <div class="swiper-slide">
                  <img src="{{$domain}}uploads/products/{{ $product->image }}" alt="" />
                </div>                                                 
              </div>
            </div>
          </div>
        </div>
        <!-- close multiple product image view -->
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <div class="product-info-section p-3">
          <h3 class="mt-3 mt-lg-0 mb-0">{{ $product->Product_Name}}</h3>
          <div class="d-flex align-items-center mt-3 gap-2">
            {{-- <h5 class="mb-0 text-decoration-line-through text-light-3">998.00 TK</h5> --}}
            <h4 class="mb-0">৳ {{ $product->Product_SellingPrice }}</h4>
          </div>
          <div class="mt-3">
          </div>
          <dl class="row mt-3">	<dt class="col-sm-3">Product Code</dt>
            <dd class="col-sm-9">{{ $product->Product_Code  }}</dd>	<dt class="col-sm-3">Delivery</dt>
            <dd class="col-sm-9">Bangladesh</dd>
          </dl>
          <form >
            @csrf
            <input type="hidden" name="txtId" id="txtId" value="{{ $product->Product_SlNo }}">
            <div class="row pt-0">
              <div class="col-md-2 col-3"><label class="col-form-label customize-label">Quantity</label></div>
              <div class="col-md-8 col-9" class="details-padding">
                <div class="btn-group qtyField" role="group" aria-label="Basic example">
                        <button type="button" class="btn qtyBtn minus btn-secondary increment decrement_details_to_cart" ><i class="fas fa-minus"></i></button>
                        <input type="number" class="btn btn-light cart-count qty" value="1" id="quantity" min="1" name="quantity">
                        <button type="button" class="btn qtyBtn plus btn-secondary decrement increment_details_to_cart" ><i class="fas fa-plus"></i></button>
                </div>                 
              </div>
            </div>
          
          <!--end row-->
          <div class="d-flex gap-2 mt-3">
            <button type="button" class="btn bg-brand" onclick="return quickOrder()"><i class="fa-solid fa-cart-plus"></i> &nbsp; Add to Cart</button>
            {{-- <button type="button" class="btn btn-light" onclick="wishAjax({{ $product->Product_SlNo }})"><i class="fa-regular fa-heart"></i> &nbsp; Add to Wishlist</button> --}}
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- close product details -->

<!-- product description -->
<section class="py-4">
  <div class="container">
      <ul class="nav nav-tabs mb-0" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" data-bs-toggle="tab" href="#discription" role="tab" aria-selected="true">
            <div class="d-flex align-items-center">
              <div class="tab-title text-uppercase fw-500">Description</div>
            </div>
          </a>
        </li>
      </ul>
      <div class="tab-content pt-3">
        <div class="tab-pane fade active show" id="discription" role="tabpanel">
           {!! $product->description !!}
        </div>  
      </div>
  </div>
</section>
<!-- close product description -->
@endsection
@push('website-js')
    <!-- zoom js -->
    <script src="{{ asset('website/jsb/swiper.min.js')}}"></script>
    <script src="{{ asset('website/jsb/easyzoom.js')}}"></script>
    <script src="{{ asset('website/jsb/main.js')}}"></script>

    <script>
      function qnt_incre(){
      $(".qtyBtn").on("click", function() {
        var qtyField = $(this).parent(".qtyField"),
        oldValue = $(qtyField).find(".qty").val(),
              id = $(qtyField).find(".quantity").val(),
          newVal = 1;
        if ($(this).is(".plus")) {
        newVal = parseInt(oldValue) + 1; 
        } else if (oldValue > 1) {
        newVal = parseInt(oldValue) - 1;
        }
      var quantity = $(qtyField).find(".qty").val(newVal);
            })
          }
      qnt_incre();
    </script>
@endpush