@extends('layouts.website')
@section('title', 'Customer Dashboard')
@push('website-css')
        <style>
            .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
                color: #495057;
                background-color: #dee1e3;
                border-color: #dee2e6 #dee2e6 #fff;
            }
            .select2 {
                width: 100%
            }
        </style>
@endpush
@section('website-content')
     <!-- customer dashboard-->
     <section class="py-4">
        <div class="container">
          <div class="card-body">
              <div class="row">              
                  <div class="col-lg-4 col-md-4 col-12">
                      <div class="card mb-md-0 mb-2">
                      <div class="card-body">
                          <ul class="nav nav-tabs mb-0 list-group list-group-flush" role="tablist">
                              <li class="nav-item custom-border-bottom" role="presentation">
                                  <a class="nav-link active" data-bs-toggle="tab" href="#dashboard" role="tab" aria-selected="true">
                                  <div class="align-items-center">
                                      <div class="tab-title fw-500 fs-14 text-dark">Dashboard <span class="float-end"> <i class="fa-solid fa-gauge-high"></i></span></div>
                                  </div>
                                  </a>
                              </li>
                              <li class="nav-item custom-border-bottom" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#orders" role="tab" aria-selected="false">
                                  <div class="align-items-center">
                                      <div class="tab-title fw-500 text-dark">Orders <span class="float-end"><i class="fa-solid fa-cart-shopping"></i></span></div>
                                  </div>
                                  </a>
                              </li>
                              <li class="nav-item custom-border-bottom" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#address" role="tab" aria-selected="false">
                                      <div class="align-items-center">
                                      <div class="tab-title fw-500 text-dark">Address <span class="float-end"><i class="fa-solid fa-house-user"></i></span></div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item custom-border-bottom" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#payment" role="tab" aria-selected="false">
                                      <div class="align-items-center">
                                      <div class="tab-title fw-500 text-dark">Payment Methods <span class="float-end"><i class="fa-solid fa-money-check-dollar"></i></span></div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item custom-border-bottom" role="presentation">
                                  <a class="nav-link" data-bs-toggle="tab" href="#account" role="tab" aria-selected="false">
                                      <div class="align-items-center">
                                      <div class="tab-title fw-500 text-dark">Account Details <span class="float-end"><i class="fa-solid fa-user"></i></span></div>
                                      </div>
                                  </a>
                              </li>
                              <li class="nav-item" role="presentation">
                                  <a class="nav-link" href="{{route('customer.logout')}}" >
                                      <div class="align-items-center">
                                      <div class="tab-title text-dark">Log out <span class="float-end"><i class="fa-solid fa-arrow-right-from-bracket"></i></span></div>
                                      </div>
                                  </a>
                              </li>
                          </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-8 col-md-8 col-12">
                      <div class="card">
                      <div class="card-body">
                          <div class="tab-content pt-3">
                              <div class="tab-pane fade active show" id="dashboard" role="tabpanel">                           
                                 <h6>Dashboard content</h6>   
                                 <h5 class="fw-bolder">Hello, {{ Auth::guard('customer')->user()->Customer_Name }}</h5>
                                <p>From your account dashboard. you can easily check & view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>                        
                              </div>
  
                              <div class="tab-pane fade" id="orders" role="tabpanel">
                                  <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th scope="col" class="text-nowrap">Invoice No</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Tolal</th>
                                            <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach($orders as $key=>$item)
                                            <tr>
                                            <th scope="row" class="text-nowrap">{{ $item->SaleMaster_InvoiceNo }}</th>
                                            <td class="text-nowrap">{{ $item->SaleMaster_SaleDate }}</td>
                                            <td class="text-nowrap">
                                                @if($item->Status == 'p')
                                                {{ 'pending' }}
                                                @elseif($item->Status == 'way')
                                                {{ 'On the Way' }}
                                                @elseif($item->Status == 'on')
                                                {{ 'On Processing' }}
                                                @elseif($item->Status == 'c')
                                                    <span class="text-danger">{{ 'cancelled' }}</span>
                                                @elseif($item->Status == 'a')
                                                {{ 'Delivered' }}
                                                @else
                                                
                                                @endif
                                            </td>

                                            <td class="text-nowrap">৳ {{ number_format($item->SaleMaster_TotalSaleAmount) }}</td>

                                            <td class="text-nowrap">
                                                <div class="d-flex gap-2">

                                                @if($item->Status != 'on' && $item->Status != 'way' && $item->Status != 'c' && $item->Status != 'a')
                                                <form action="{{route('product.order.delete',$item->SaleMaster_SlNo)}}" method="post">
                                                    @csrf                     
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Cancel" onclick="return confirm('Are you sure you want to cancel this order?');">Cancle</button>
                                                </form>
                                                @endif
                                                
                                                <a href="{{ route('customer-invoice', $item->SaleMaster_SlNo) }}" class="btn btn-sm bg-brand">Invoice</a>
                                                </div>
                                            </td>
                                            
                                            </tr>   
                                            @endforeach
                                        </tbody>
                                    </table>                                                                                
                                  </div>   
                              </div>
                              <div class="tab-pane fade" id="address" role="tabpanel">
                                  <h6 class="mb-4">The following addresses will be used on the checkuot page by default.</h6>
                                  <form action="{{ route('auth.customer.address') }}" method="post">
                                    @csrf
                                  <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="mb-3">
                                            <label for="district_id" class="form-label">District</label>
                                            <select  class="form-control custom-form-control @error('district_id') is-invalid @enderror" id="district_id" name="district_id" onchange="fetchUpazila(this.value)">
                                                <option value="">Select District</option>
                                                @foreach($districts as $key=>$item)                                                 
                                                    <option value="{{ $item->District_SlNo }}" {{ $item->District_SlNo == Auth::guard('customer')->user()->area_ID ? 'selected':'' }}>{{ $item->District_Name }}</option>                                                  
                                                @endforeach
                                            </select>
                                            @error('district_id')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                      </div>  
                                      <div class="col-lg-6 col-md-6 col-12">
                                        <div class="mb-3">
                                            <label for="upazila_id" class="form-label">Upazila</label>
                                            <select  class="form-control custom-form-control @error('upazila_id') is-invalid @enderror" id="upazila_id" name="upazila_id">
                                               <option value="">Select Upazila</option>
        
                                               @foreach($upazilas as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == Auth::guard('customer')->user()->upazila_id ? 'selected':'' }}>{{ $item->name }}</option>
                                               @endforeach
                                            </select>
                                            @error('upazila_id')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                      </div>
        
                                      <div class="col-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea  class="form-control custom-form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" rows="3" cols="20">{{ Auth::guard('customer')->user()->Customer_Address }}</textarea>
                                            @error('address')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                      </div>

                                      <div class="col-12">
                                        <div class="d-md-block mt-3">
                                            <button class="btn bg-brand" type="submit">Save Changes</button>
                                          </div>
                                      </div>
                            
                                  </div>
                                </form>
                              </div>
  
                              <div class="tab-pane fade" id="payment" role="tabpanel">
                                  <h6>Payment</h6> 
                              </div>
  
                              <div class="tab-pane fade" id="account" role="tabpanel">
                                  <form action="{{ route('auth.customer.update') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                  <div class="row">
                                      <div class="col-lg-6 col-md-6 col-12">                                    
                                          <label for="exampleFormControlInput1" class="form-label">Name</label>
                                          <input type="text" class="form-control custom-form-control @error('name') is-invalid @enderror" id="name" placeholder="name" name="name" value="{{ Auth::guard('customer')->user()->Customer_Name }}">  
                                          @error('name')      
                                          <span><strong>{{ $message }}</strong></span>  
                                          @enderror                             
                                      </div>
                                      <div class="col-lg-6 col-md-6 col-12">
                                          <label for="exampleFormControlInput1" class="form-label">User Name</label>
                                          <input type="text" class="form-control custom-form-control @error('username') is-invalid @enderror" id="username" placeholder="username" value="{{ Auth::guard('customer')->user()->Customer_Name }}" name="username" readonly>  
                                          @error('username')      
                                          <span><strong>{{ $message }}</strong></span>  
                                          @enderror                                      
                                      </div>
                                      <div class="col-12">
                                          <label for="exampleFormControlInput1" class="form-label">Phone </label>
                                          <input type="text" class="form-control custom-form-control @error('phone') is-invalid @enderror" id="phone" placeholder="phone" name="phone" value="{{ Auth::guard('customer')->user()->Customer_Phone }}">
                                          @error('phone')      
                                          <span><strong>{{ $message }}</strong></span>  
                                          @enderror 
                                      </div>
                                      <div class="col-12">
                                          <label for="exampleFormControlInput1" class="form-label">Email Address</label>
                                          <input type="email" class="form-control custom-form-control @error('email') is-invalid @enderror" id="email" placeholder="email" name="email" value="{{ Auth::guard('customer')->user()->Customer_Email }}">
                                          @error('email')      
                                          <span><strong>{{ $message }}</strong></span>  
                                          @enderror 
                                      </div>

                                      
                                      <div class="col-12">
                                          <label for="exampleFormControlInput1" class="form-label">Password</label>
                                          <input type="password" class="form-control custom-form-control @error('cpassword') is-invalid @enderror" id="cpassword" name="cpassword" placeholder="password"> 
                                      </div>

                                      <div class="col-12">
                                        <label for="exampleFormControlInput1" class="form-label">Re-Type Password</label>
                                        <input type="password" class="form-control custom-form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="retype-password">
                                        @error('password')      
                                        <span><strong>{{ $message }}</strong></span>  
                                        @enderror 
                                      </div>

                                      <div class="col-8">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="profile_picture" id="image" onchange="readURL(this);">
                                      </div>
                                      <div class="col-4">
                                        <label for="exampleFormControlInput1" class="form-label"></label>
                                        <div id="preview" class="d-flex">                   
                                            <span class="ms-auto"> <img src="" alt="" id="previewImage" class="me-auto" style="height: 60px;width:60px; border:1px solid #B4B5B6"></span>
                                        </div>
                                      </div>

                                      <div class="col-12">
                                          <div class="d-md-block mt-3">
                                              <button class="btn bg-brand" type="submit">Save Changes</button>
                                            </div>
                                      </div>
                                  </div>
                                </form>
                              </div>
  
                          </div> 
                      </div>
                    </div>
                  </div>
              </div>
          </div>

        </div>
      </section>
      <!-- close customer dashboard -->

    @push('website-js')

        <!-- <script>
            $(document).ready(function() {
                $('#country').select2();
                $('#district').select2();
            });
        </script> -->

        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage')
                            .attr('src', e.target.result)
                            .width(100);

                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            document.getElementById("previewImage").src ="{{ asset('/uploads/customer') }}/{{ Auth::guard('customer')->user()->profile_picture ? Auth::guard('customer')->user()->profile_picture : '/noimage.png' }} ";
        </script>

        <script>
            function fetchUpazila(id){
                
                //alert(id);
                let url = 'fetch-upazila/'+id;
                $.ajax({
                    url:url,
                    method:"get",
                    success:function(data){
                        $('#upazila_id').html(data);
                    }
                })
            }
        </script>
    @endpush
@endsection
