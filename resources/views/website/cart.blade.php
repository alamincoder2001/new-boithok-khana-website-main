@extends('layouts.website')
@section('title','Cart')
@section('website-content')

<!-- cart-list-section start -->
<section class="py-md-4 py-5 mt-md-0 mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card mb-3 mt-3">                 
                    <div class="card-body">
                        <form action="#" method="get" id="selectedCart"></form>  
                            @csrf
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="checkAll" form="selectedCart">
                                    <label class="form-check-label" for="checkAll">
                                    Select All
                                    </label>
                                </div>

                                <div>
                                    <button class="btn" type="submit" form="selectedCart"><i class="fa-solid fa-trash-can cart-trash"></i></button>
                                </div>
                            </div>                                               
                    </div>
                </div>

                <div class="cart-left-side">
                    
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Cart Summery</h5>
                            <div class="get-total-part d-flex">
                                <span class="fw-bolder">Sub Total</span>
                                <span class="ms-auto" id="cart-subtotal">{{ Cart::getTotal() }}</span>
                            </div>
                            <a href="{{ route('checkout') }}" class="btn w-100 bg-brand text-white">Processed to Checkout</a>
                            <a href="{{ route('home') }}" class="btn form-control mt-3 btn-secondary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
</section>

<!-- cart-list-section  end -->
@endsection
@push('website-js')
<script>
cartPage();
function cartPage(){
    $.ajax({
            url:"{{route('cart.alldata')}}",
            type:"get",
            dataType: "json",
            success:function(res){
                var data = ''; 
                $('#cart-item').text(res.total_item);
                $('#cart-number').text(res.total_item);
                $('#cart-itemhover').text(res.total_item);
                $('#subtotal').text('৳ '+res.total_amount);
                $('#cart-subtotal').text('৳ '+res.total_amount);         
                $.each(res.cart,function(key,value){
                    data+='<div class="card rounded-0">';
                        data+='<div class="card-body">';
                        data+='<div class="row">';
                        data+='<div class="col-1 align-self-center">';
                        data+='<div class="text-end"><input class="form-check-input check" type="checkbox" value="'+value.id+'" name="cartChecked[]" form="selectedCart"></div>';
                        data+='</div>';
                        data+='<div class="col-lg-6 col-md-6 col-11">';
                        data+='<div class="d-flex gap-3">';
                        data+='<div>';
                        data+='<a href="#"><img src="'+value.attributes.image+'" alt="" class="rounded border border-1 cart-details-img"></a>';
                        data+='</div>';
                        data+='<div>';
                        data+='<p class="cart-detail-product-name">'+value.name+'</p>';
                        data+='<p class="cart-detail-product">'+value.quantity+' X ৳ '+value.price+'</p>';
                        data+='</div>';
                        data+='</div>';
                        data+='</div>';
                        data+='<div class="col-lg-2 col-md-2 col-12 align-self-center">';
                        data+='<h6 class="text-enter py-md-0 py-3">৳ '+value.price*value.quantity+'</h6>';
                        data+='</div>';
                        data+='<div class="col-lg-3 col-md-3 col-12 align-self-center">';
                        data+='<div class="d-flex gap-3 justify-content-center">';
                        data+='<div class="cart-circle"  onclick="cartDecrement('+value.id+')"><i class="fa-solid fa-minus" style="color: gray"></i></div>';
                        data+='<div><span style="color: gray" id="singlequantity'+value.id+'">'+value.quantity+'</span></div>';                     
                        data+='<div class="cart-circle" onclick="cartIncrement('+value.id+')"><i class="fa-solid fa-plus" style="color: gray"></i></div>';
                        data+='<div><a href="javascript:void()" onclick="cartDelete('+value.id+')"><i class="fa-solid fa-trash-can cart-trash"></i></a></div>';
                        data+='</div>';
                        data+='</div>';
                        data+='</div> ';                                                
                        data+='</div>';
                    data+='</div>';

                });
                $('.cart-left-side').html(data);                 
            }
    });
}
</script>
<script>
    function cartIncrement(id){
        let url = '/cart/increment/'+id;

        $.ajax({
            url:url,
            method:'get',
            dataType:"json",
            success:function(res){
                $('singlequantity'+id).val(res.quantity);              
                $('#subtotal').text('৳ '+res.total_amount);
                $('#cart-subtotal').text('৳ '+res.total_amount);

               //cart page js
                var data = '';  
                if(res.error == 'out'){
                    toastr.error('Stock have no available');
                } 
                else{                   
                $.each(res.cartItem,function(key,value){
                    data+='<div class="card rounded-0">';
                        data+='<div class="card-body">';
                        data+='<div class="row">';
                        data+='<div class="col-1 align-self-center">';
                        data+='<div class="text-end"><input class="form-check-input check" type="checkbox" value="'+value.id+'" name="cartChecked[]" form="selectedCart"></div>';
                        data+='</div>';
                        data+='<div class="col-lg-6 col-md-6 col-11">';
                        data+='<div class="d-flex gap-3">';
                        data+='<div>';
                        data+='<a href="#"><img src="'+value.attributes.image+'" alt="" class="rounded border border-1 cart-details-img"></a>';
                        data+='</div>';
                        data+='<div>';
                        data+='<p class="cart-detail-product-name">'+value.name+'</p>';
                        data+='<p class="cart-detail-product">'+value.quantity+' X ৳ '+value.price+'</p>';
                        data+='</div>';
                        data+='</div>';
                        data+='</div>';
                        data+='<div class="col-lg-2 col-md-2 col-12 align-self-center">';
                        data+='<h6 class="text-enter py-md-0 py-3">৳ '+value.price*value.quantity+'</h6>';
                        data+='</div>';
                        data+='<div class="col-lg-3 col-md-3 col-12 align-self-center">';
                        data+='<div class="d-flex gap-3 justify-content-center">';
                        data+='<div class="cart-circle"  onclick="cartDecrement('+value.id+')"><i class="fa-solid fa-minus" style="color: gray"></i></div>';
                        data+='<div><span style="color: gray" id="singlequantity'+value.id+'">'+value.quantity+'</span></div>';                     
                        data+='<div class="cart-circle" onclick="cartIncrement('+value.id+')"><i class="fa-solid fa-plus" style="color: gray"></i></div>';
                        data+='<div><a href="javascript:void()" onclick="cartDelete('+value.id+')"><i class="fa-solid fa-trash-can cart-trash"></i></a></div>';
                        data+='</div>';
                        data+='</div>';
                        data+='</div> ';                                                
                        data+='</div>';
                    data+='</div>';

                });
                $('.cart-left-side').html(data); 
                }  
            }
        })
    }

    function cartDecrement(id){
        let url = '{{ asset('') }}'+'cart/decrement/'+id;
        console.log(id);
        $.ajax({
            url:url,
            method:'get',
            dataType:"json",
            success:function(res){
                $('singlequantity'+id).val(res.quantity);
                $('#subtotal').text('৳ '+res.total_amount);
                $('#cart-subtotal').text('৳ '+res.total_amount);

               //cart page js
                var data = '';             
                $.each(res.cartItem,function(key,value){
                    data+='<div class="card rounded-0">';
                        data+='<div class="card-body">';
                        data+='<div class="row">';
                        data+='<div class="col-1 align-self-center">';
                        data+='<div class="text-end"><input class="form-check-input check" type="checkbox" value="'+value.id+'" name="cartChecked[]" form="selectedCart"></div>';
                        data+='</div>';
                        data+='<div class="col-lg-6 col-md-6 col-11">';
                        data+='<div class="d-flex gap-3">';
                        data+='<div>';
                        data+='<a href="#><img src="'+value.attributes.image+'" alt="" class="rounded border border-1 cart-details-img"></a>';
                        data+='</div>';
                        data+='<div>';
                        data+='<p class="cart-detail-product-name">'+value.name+'</p>';
                        data+='<p class="cart-detail-product">'+value.quantity+' X ৳ '+value.price+'</p>';
                        data+='</div>';
                        data+='</div>';
                        data+='</div>';
                        data+='<div class="col-lg-2 col-md-2 col-12 align-self-center">';
                        data+='<h6 class="text-enter py-md-0 py-3">৳ '+value.price*value.quantity+'</h6>';
                        data+='</div>';
                        data+='<div class="col-lg-3 col-md-3 col-12 align-self-center">';
                        data+='<div class="d-flex gap-3 justify-content-center">';
                        data+='<div class="cart-circle"  onclick="cartDecrement('+value.id+')"><i class="fa-solid fa-minus" style="color: gray"></i></div>';
                        data+='<div><span style="color: gray" id="singlequantity'+value.id+'">'+value.quantity+'</span></div>';                     
                        data+='<div class="cart-circle" onclick="cartIncrement('+value.id+')"><i class="fa-solid fa-plus" style="color: gray"></i></div>';
                        data+='<div><a href="javascript:void()" onclick="cartDelete('+value.id+')"><i class="fa-solid fa-trash-can cart-trash text-danger"></i></a></div>';
                        data+='</div>';
                        data+='</div>';
                        data+='</div> ';                                                
                        data+='</div>';
                    data+='</div>';

                });
                $('.cart-left-side').html(data); 
            }
        })
    }
</script>


<script>
        $("#checkAll").click(function () {
            $(".check").prop('checked', $(this).prop('checked'));
        });
</script>

<script>
$( "#selectedCart" ).on( "submit", function( event ) {
  event.preventDefault();

    let data = $("#selectedCart").serializeArray();
    let url = 'cart-selected-remove';
    if(data == ''){
        alert('Please Select at least one item');
    }
    else{
        $.ajax({
        url: url,
        data:data,
        method:"get",
        dataType: "json",
        success:function(res){
            cartPage();
            cartHomePage();
        }
      })
    }
    

});
</script>
@endpush