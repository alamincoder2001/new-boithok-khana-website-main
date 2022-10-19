@extends('layouts.website')
@section('title', 'Home')
@section('website-content')
<!-- Quick Order Section -->
<section class="pb-4" style="background: rgb(0 0 0 / 40%) url({{asset('background.jpg')}});background-position: center;background-repeat: no-repeat;background-size: 100% 100%;background-blend-mode: darken;">
  <div class="container pt-5 pb-4">
      <div class="row">
          <div class="col-md-8 col-12">
                @if(count($data['banners'])>0)
                <div class="row">
                    <div class="col-md-2 col-6">
                        <div class="banner_img_ino top-50 start-50">
                            @isset($data['banners'][0]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][0]->image }}" class="w-100 banner-img-1" alt="">
                            @endisset                        
                        </div>
                    </div>
        
                    <div class="col-md-2 col-6">
                        <div class="banner_img_two">
                            @isset($data['banners'][1]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][1]->image }}" class="w-100 mb-3 banner-img-2" alt="">
                            @endisset
                            @isset($data['banners'][2]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][2]->image }}" class="w-100 banner-img-3" alt="">
                            @endisset
                        </div>
                    </div>
        
                    <div class="col-md-2 col-6">
                        <div class="banner_img_three">
                            @isset($data['banners'][3]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][3]->image }}" class="w-100 mb-3 banner-img-4" alt="">
                            @endisset
                            @isset($data['banners'][4]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][4]->image }}" class="w-100 banner-img-5" alt="">
                            @endisset
                        </div>
                    </div>
        
                    <div class="col-md-2 col-6">
                        <div class="banner_img_four">
                            @isset($data['banners'][5]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][5]->image }}" class="w-100 mb-3 banner-img-6" alt="">
                            @endisset
                            @isset($data['banners'][6]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][6]->image }}" class="w-100 banner-img-7" alt="">
                            @endisset
                        </div>
                    </div>
        
                    <div class="col-md-2 col-6">
                        <div class="banner_img_five">
                            @isset($data['banners'][7]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][7]->image }}" class="w-100 mb-3 banner-img-8" alt="">
                            @endisset
                            @isset($data['banners'][8]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][8]->image }}" class="w-100 banner-img-9" alt="">
                            @endisset
                        </div>
                    </div>
        
                    <div class="col-md-2 col-6">
                        <div class="banner_img_ino top-50 start-50">
                            @isset($data['banners'][9]->image)
                                <img src="{{$domain}}uploads/banners/{{ $data['banners'][9]->image }}" class="w-100 banner-img-1" alt="">
                            @endisset
                        </div>
                    </div>
                </div>
                @endif
          </div>
          <div class="col-md-4 col-12">
              <div class="quick_order mt-md-0 mt-3">
                  <h3 class="mb-3">You Can Quick Order</h3>
                  <form action="{{ route('quickOrder.website') }}" method="post" id="QuickOrderForm">
                      @csrf

                      <div class="mb-2 row">
                          <label for="" class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" name="name" id="name" class="form-control shadow-none @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                      </div>

                      <div class="mb-2 row">
                          <label for="" class="col-sm-3 col-form-label">Phone</label>
                          <div class="col-sm-9">
                            <input type="text" name="phone" id="phone" class="form-control shadow-none @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                      </div>

                      <div class="mb-2 row">
                          <label for="" class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror" id="address" rows="2">{{ old('address') }}</textarea>
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                      </div>
                    </form> 
                      <div class="mb-2 row">
                          <label for="" class="col-sm-3 col-form-label"><b>Product</b> </label>
                          <div class="col-sm-9">
                              <select name="txtId" id="txtId" class="form-control shadow-none p-1" required>
                                  <option value="">Select Product option</option> 
                                  @foreach ($data['products'] as $item)
                                      <option value="{{ $item->Product_SlNo }}" data-price="{{ $item->Product_SellingPrice }}">{{ $item->Product_Name }}</option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <div class="mb-2 row">                
                          <label for="" class="col-sm-3 col-form-label"><b>Quatity</b></label>
                          <div class="col-sm-7 pe-0">
                            <input type="number" name="quantity" id="quantity" class="form-control shadow-none qty" required>
                          </div>
                          <div class="col-md-2 ps-1">
                              <button style="height: 100%;" type="button" onclick="return quickOrder()" class="btn-sm btn-danger shadow-none border-0 w-100"><i class="fa-solid fa-plus"></i></button>
                          </div>                       
                      </div>
                
                      <hr>
                      <div class="product_list">
                              <table class="table table-bordered text-center Quickdata">
                                  
                              </table>                         
                      </div>
                      <div class="d-flex justify-content-end">
                          <button type="submit" class="quick_btn" form="QuickOrderForm">Order Now</button>
                      </div>  
                                                            
              </div>
          </div>
      </div>
  </div>
</section>

<!-- category food section-->
<section class="pt-3 category-section">
      <div class="container">
          <div class="row">
              <div class="col-sm-12">
                  <div class="category-food">
                      <h2 class="text-center">Our Category</h2>
                  </div>
              </div>
          </div>
          <div class="row pt-3">
              @foreach ($category->take(12) as $item)
              <div class="col-lg-2 col-md-2 col-6 mb-4">
                  <div class="card p-1 text-center cat_card">
                      <a href="{{ route('categorywise', $item->ProductCategory_SlNo) }}">
                          <img src="{{$domain}}/uploads/productcategory/{{$item->image}}" class="img-fluid" alt="">
                      </a>
                      <div class="py-2">
                          <a href="{{ route('categorywise', $item->ProductCategory_SlNo) }}"><h4 class="category-name">{{ $item->ProductCategory_Name }}</h4></a>
                      </div>
                  </div>
              </div>
              @endforeach
          </div>
      </div>
</section>

<!-- category wise product -->
@if(count($data['all'])>0)
<section id="explore-food">
    @foreach ($data['all'] as $itemone)
        <div class="explore-food">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pt-3">
                            <h2 class="text-center">{{ $itemone->name }}</h2>
                        </div>
                    </div>
                </div>
    
                <div class="row pt-3">
                    @if(count($itemone->published)>0)
                        @foreach ($itemone->published as $item)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card food_card">
                                <a href="{{ route('productDetails', optional($item->product)->Product_SlNo) }}">
                                    <img src="{{$domain}}uploads/products/{{$item->product->image}}" class="img-fluid w-100" alt="">
                                </a>
                                
                                <div class="p-3">
                                    <h4 title="{{ optional($item->product)->Product_Name }}" class="product-title">{{ Str::words(optional($item->product)->Product_Name, '2', '...') }}</h4>
                                    <p class="p-0 m-0 product-info">৳ {{ optional($item->product)->Product_SellingPrice }}</p>
                                            
                                    <div class="food_btn d-flex justify-content-between">
                                        <div><a href="{{ route('productDetails', optional($item->product)->Product_SlNo) }}">View Details &nbsp;<i class="fa-solid fa-right-long"></i></a></div>
                                        <div class="btn btn-sm rounded-pill cart-btn" onclick="cartAjax({{ optional($item->product)->Product_SlNo }})"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Add To Cart</div>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                        @endforeach  
                    @endif         
                </div>
            </div>
        </div>
    @endforeach
</section>
@endif

<!-- section-5 explore food -->
<section id="explore-food" class="">
    <div class="explore-food">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="pt-3">
                        <h2 class="text-center">ALL Products</h2>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                @foreach ($data['products'] as $item)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card food_card">
                        <a href="{{ route('productDetails', $item->Product_SlNo) }}">
                            <img src="{{$domain}}uploads/products/{{($item->image)}}" class="img-fluid w-100" alt="">
                        </a>
                        
                        <div class="p-3">
                            <h4 title="{{ $item->Product_Name }}" class="product-title">{{ Str::words($item->Product_Name, '2', '...') }}</h4>
                            <p class="p-0 m-0 product-info">৳ {{ $item->Product_SellingPrice }}</p>     
                            <div class="food_btn d-flex justify-content-between">
                                <div><a href="{{ route('productDetails', $item->Product_SlNo) }}">View Details &nbsp;<i class="fa-solid fa-right-long"></i></a></div>
                                <div class="btn btn-sm rounded-pill cart-btn" onclick="cartAjax({{ $item->Product_SlNo }})"><i class="fa-solid fa-cart-shopping"></i>&nbsp;&nbsp;Add To Cart</div>
                            </div>
                        </div>                                        
                    </div>
                </div>
                @endforeach           
            </div>
        </div>
    </div>
  </section>


<!-- Start Book food Section -->
<section id="book-food">
    <div class="book-food" style="background-image:url('{{$domain}}uploads/adss/16618515941.jpg')">
        <div class="container book-food-text">
            <div class="row text-center">
                <div class="col-12">
                    <h2 class="text-white ad-titles">@isset($data['after_product']->title)
                        {{ $data['after_product']->title }}
                    @endisset</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Book food Section -->

<!-- Our Expert Shape -->
<section class="expert-food">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="pt-3">
                    <h2 class="text-center">Our Expert Shape</h2>
                </div>
            </div>
        </div>

        <div class="row pt-3">
            @foreach ($data['shapes'] as $item)
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card p-2 expert_card">
                    <img src="{{$domain}}uploads/shape/{{ $item->image }}" loading="lazy" class="img-fluid" alt="">
                    <div class="py-3 text-center">
                        <h3>{{ $item->name }}</h3>
                        <h4>{{ $item->designation }}</h4>
                        <div class="social">
                            <a href="/{{$item->facebook }}" target="_blank" class="fb"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="{{$item->twitter}}" target="_blank" class="twitter"><i class="fa-brands fa-twitter"></i></a>
                            <a href="{{$item->instagram}}" target="_blank" class="instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="{{$item->linkedin}}" target="_blank" class="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach                
        </div>
    </div>
</section>

@endsection
@push('website-js')

@endpush


