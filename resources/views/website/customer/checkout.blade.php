@extends('layouts.website')
@section('title','Order Checkout')
@section('website-content')

<!-- cart-section  section start-->
<section class="py-md-4 py-5 mt-md-0 mt-4">
  <form action="{{route('checkout.store')}}" method="POST">
    @csrf
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-7 col-12">
          <div class="card custom-card mb-3">
            <div class="card-body">
              <div class="row">
                <span class="fst-italic text-muted">step 1 of 2</span>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="mb-3">
                    <label for="customer_name" class="form-label">Contact</label>
                    <input type="text" class="form-control custom-form-control @error('customer_name') is-invalid @enderror" placeholder="Contact Name" name="customer_name" id="customer_name" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Name : session('name') }}">
                    @error('customer_name')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="mb-3 mt-2">
                    <label for="customer_mobile" class="form-label"></label>
                    <input type="text" class="form-control custom-form-control @error('customer_mobile') is-invalid @enderror" id="customer_mobile" name="customer_mobile" placeholder="Mobile Number" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Phone : session('phone') }}">
                    @error('customer_mobile')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                </div>

                <div class="col-lg-6 col-md-6 col-12">
                  <div class="mb-3">
                    <input type="email" class="form-control custom-form-control" id="customer_email" name="customer_email" placeholder="Email" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Email : '' }}">
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="mb-3">
                    <input type="text" class="form-control custom-form-control" id="username" name="username" placeholder="username" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Name : session('name') }}" disabled>
                  </div>
                </div>


                <div class="col-lg-6 col-md-6 col-12">
                  <div class="mb-3">
                    <label for="district_id" class="form-label">Address <small class="fst-italic">(shipping)</small></label>
                    <select class="form-control custom-form-control @error('district_id') is-invalid @enderror" id="district_id" name="district_id" onchange="fetchUpazila(event)">
                      <option value="">Select District</option>
                      @foreach($districts as $key=>$item)
                      <option data-price="{{ $item->charge_amount }}" value="{{ $item->District_SlNo }}">{{ $item->District_Name }}</option>
                      @endforeach
                    </select>
                    @error('district_id')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="mb-3 mt-2">
                    <label for="upazila_id" class="form-label"></label>
                    <select onchange="shippingCharge(event)" class="form-control custom-form-control @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id">
                      <option value="">Select Upazila</option>
                    </select>
                    @error('upazila_id')
                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="mb-3">
                    <textarea class="form-control custom-form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" placeholder="Address" rows="3" cols="20">{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Address : session('address') }}</textarea>
                    @error('shipping_address')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                  </div>
                </div>

                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="billDifferent" name="billDifferent">
                    <label class="form-check-label" for="billDifferent">
                      Bill To A Different Address?
                    </label>
                  </div>
                </div>

                <!-- Billing Address -->
                <fieldset class="billingDiff hide">
                  <div class="row">
                    <!-- <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3">
                                    <label for="bname" class="form-label">Address <small class="fst-italic">(Billing)</small></label>
                                    <input class="form-control custom-form-control @error('bname') is-invalid @enderror" id="bname" name="bname" placeholder="Name" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Name : '' }}">
                                    @error('bname')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                              </div>  
                              <div class="col-lg-6 col-md-6 col-12">
                                <div class="mb-3 mt-2">
                                    <label for="bphone" class="form-label"></label>
                                    <input class="form-control custom-form-control @error('bphone') is-invalid @enderror" id="bphone" name="bphone" placeholder="Phone" value="{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Mobile : '' }}">
                                    @error('bphone')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                              </div> -->

                    <div class="col-12">
                      <div class="mb-3">
                        <textarea class="form-control custom-form-control @error('billing_address') is-invalid @enderror" id="billing_address" name="billing_address" placeholder="Please write full address" rows="3" cols="20">{{ Auth::guard('customer')->user() ? Auth::guard('customer')->user()->Customer_Address : session()->get('address') }}</textarea>
                        @error('billing_address')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </fieldset>

                <!-- close Billing Address -->
              </div>
            </div>
          </div>

          <div class="card custom-card mb-3">
            <div class="card-body">
              <span class="fst-italic text-muted">step 2 of 2</span>
              <h5 class="fw-bold mb-3">Payment Method</h5>

              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" checked>
                <label class="form-check-label" for="flexRadioDefault1">
                  Mobile Payment
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                  Cash On Delivery
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-5 col-md-5 col-12">
          <div class="card custom-card">
            <div class="card-body">
              <h4>Order Summary</h4>
              <div class="order-summary-table table-responsive text-center">
                <table class="table table-bordered">
                  <thead class="bg-light">
                    <tr>
                      <th>Products</th>
                      <th>Price/Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody class="order-summary">


                  </tbody>
                  <tfoot>
                    <tr>
                      <td></td>
                      <td>Sub Total</td>
                      <td><strong id="ship-subtotal">{{\Cart::getTotal()}} Tk</strong></td>
                    </tr>
                    <tr>
                      <td></td>
                      <td>Shipping</td>
                      <td class="d-flex justify-content-center" id="charge-show">
                        ৳ 0
                      </td>
                      <input type="hidden" name="charge" id="charge" class="charge" value="0">
                    </tr>
                    <tr>
                      <td></td>
                      <td>Total Amount</td>
                      <td><strong id="ship-total">{{\Cart::getTotal() + 0}} Tk</strong></td>
                      <input type="hidden" id="total_amount" name="total_amount" value="{{\Cart::getTotal()}}">
                    </tr>
                  </tfoot>
                </table>
              </div>

              <div class="mb-3 mt-1">
                <label for="cus_message" class="form-label">Customer Message</label>
                <input type="text" class="form-control custom-form-control" id="cus_message" name="cus_message" placeholder="Customer Message">
              </div>

              <input type="submit" class="btn w-100 bg-brand text-white" value="Confirm">
            </div>
          </div>
        </div>
      </div>

    </div>
  </form>
</section>
@endsection
@push('website-js')
<script>
  function fetchUpazila(event) {
    if (event.target.value != "") {
      //alert(id);
      let url = 'fetch-upazila/' + event.target.value;
      $.ajax({
        url: url,
        method: "get",
        beforeSend: () => {
          $('#upazila_id').html(`<option value="">Select Upazila</option>`);
        },
        success: function(data) {
          $.each(data, (index, value) => {
            $('#upazila_id').append(`<option data-price="${value.charge_amount}" value="${value.id}">${value.name}</option>`);
          })
        }
      })
    }
  }

  function shippingCharge(event) {
    var amount = $("#upazila_id option:selected").attr("data-price");
    var t = "{{\Cart::getTotal()}}";
    var total = +t + Number(amount);
    if (event.target.value) {
      $("#charge-show").text("৳ " + amount)
      $("#charge").val(amount)
      $("#ship-total").text("৳ " + total)
      $("#total_amount").val(total)
    } else {
      $("#charge-show").text("৳ 0")
      $("#charge").val(0)
      $("#ship-total").text("৳ " + t)
      $("#total_amount").val(t)
    }
  }

</script>
<script>
  $(document).ready(function() {
    // $(".billingDiff").hide();
    $("#billDifferent").click(function() {
      $(".billingDiff").toggle();
    });
  });
</script>
<script>
  shippingPage(0);

  function shippingPage(charge) {

    $.ajax({
      url: "{{route('cartShipping.alldata')}}",
      type: "get",
      success: function(res) {
        var data = '';
        $('#cart-item').text(res.total_item);
        $('#cart-number').text(res.total_item);
        $('#cart-itemhover').text(res.total_item);
        $('#subtotal').text('৳ ' + res.total_amount);
        $('#cart-subtotal').text('৳ ' + res.total_amount);
        $('#ship-subtotal').text('৳ ' + res.total_amount);
        let total = charge + res.total_amount;
        $('#ship-total').text('৳ ' + total);
        $.each(res.cart, function(key, value) {
          data += '<tr>'
          data += '<td><a>' + value.name + '</a></td>'
          data += '<td><a>৳ ' + value.price + ' <strong> × ' + value.quantity + '</strong></a></td>'
          data += '<td>৳ ' + value.price * value.quantity + '</td>'
          data += '</tr>'
        });
        $('.order-summary').html(data);
      }
    });
  }
</script>
@endpush