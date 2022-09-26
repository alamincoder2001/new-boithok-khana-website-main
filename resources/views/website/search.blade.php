@extends('layouts.website')
@section('title', 'Search Result')
@section('website-content')

<section>
    <div class="container custom-container my-3">

        @if(count($search_result)>0)
        <div class="product-title-part d-flex">
            <div class="my-auto">
                <h4 class="product-cat-title">Product of Search </h4>
            </div>
        </div>
        @endif

        <div class="row">
            @forelse($search_result as $item)
                <div class="col-md-2 col-6">
                        <div class="product-single-item text-center">
                            <div class="product-single-inner-img">
                                @foreach ($item->inventory as $item2)
                                <a href="#" class="hover-hide">
                                    
                                    @if ($loop->first)
                                    <img src="{{asset($item2->image)}}" alt="" class="first-img" id="first-img{{$item2->id}}">
                                    @endif
                                
                                </a>
                                <a href="#" class="hover-part">                                  
                                    @if($loop->last)
                                    <img src="{{asset($item2->image)}}" alt="" class="hover-product">
                                    @endif
                                </a>
                                @endforeach
                                <button class="btn btn-success quick-btn " data-bs-toggle="modal" data-bs-target="#myModal" onclick="productView({{$item->id}})">Quick View</button>

                            </div>
                            <h5 class="mh-0"><a href="#" class="text-start">{{$item->name}}</a></h5>
                            <h5 class="mt-2">@if($item->discount>0) <del><span class="m-price">৳ {{ number_format($item->inventory[0]->price) }}</span></del> from @endif <span class="d-price">৳ @if($item->discount>0)@php echo number_format(calculateDiscount($item->inventory[0]->price,$item->discount)) @endphp @else {{ number_format($item->inventory[0]->price) }} @endif</span></h5>
                            <div class="redio-btn-group text-start">
                                @foreach ($item->inventory as $item2)
                                <span class="btn color-btn red-btn" style="background: {{$item2->color->code}}" title="{{$item2->color->name}}" onclick="colorWithImage('{{$item2->image}}',this,{{$item2->id}})"></span>
                                @endforeach
                                
                            </div>

                            <div class="product-select-group d-flex mx-2">
                                <a href="{{ route('productDetails',$item->slug) }}" class="btn p-select-btn my-auto">View Details</a>
                                <a href="#" class="link-wishlist my-auto mx-auto"><i class="fa-solid fa-heart p-inner-wish-list"></i></a>
                                <a href="javascript:void()" class="link-wishlist my-auto mx-auto" onclick="cartAjax({{ $item->id }})"><i class="fas fa-shopping-cart p-inner-wish-list"></i></a>
                            </div>
                        </div>
                </div>
                @empty
                <h4 class="text-center color-brand my-5">Product Not Available of this keyword!</h4>
            @endforelse   
        </div>
    </div>
</section>
@endsection
     
       
    
   
        
            
       

       
       
        
            
                
                    
              
            
        
    
    
       
        
       
