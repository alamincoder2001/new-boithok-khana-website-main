@extends('layouts.website')
@section('title', 'Customer Invoice')
@push('website-css')
<style>
    td, th{
        border: 1px solid #B4B5B6
    }
</style>
@endpush  
@section('website-content')
<div class="container my-4" >
    <div style="margin: auto;" >
      <div class="row justify-content-center">
          <div class="col-8">

            <div class="alert alert-success my-2" role="alert">
              <i class="fa-solid fa-circle-check"></i>&nbsp;Successfully Completed Your Order
            </div>

              <div class="card mb-3 px-2" >               
                  <div class="card-body" id="printableArea"  style="background-color: #fff !important" >
                    <style>
                        @media print{
                            body{
                            background-color: #fff !important
                            }
                        }                       
                    </style>
                    <div style="background: gray;padding: 0px 10px;">
                        <div style="display:flex;padding-top:6px;">
                          <div class="logo-img" style="width: 50%">
                            <img src="{{$domain}}uploads/company_profile_org/{{$content->Company_Logo_org}}" alt="logo" style="height: 50px;width:auto">
                          </div>
                          <div style="width: 50%">
                            <h3 style="text-align: right; margin:15px 0px;float:right">Invoice &nbsp;&nbsp;#{{ $orders->SaleMaster_InvoiceNo }}</h3> 
                          </div>
                        </div>    

                        <div style="border-bottom:1px dotted #B4B5B6"></div>

                      </div>
                      <div style="display: flex;width:100%">
                        <div style="width: 30%;">
                          <p class="mt-2 mb-2"><b>{{ $content->Company_Name }}</b></p>
                          <p>{{ $content->Repot_Heading }}</p>
                        </div>
                        <div style="width: 70%;"  >
                          <p style="text-align: right;"><b>Invoice to</b></p>
                            <p style="text-align: right; margin-bottom:0"><strong>Name: </strong>{{ $orders->customer->Customer_Name }}<br><strong>Phone:</strong> {{  $orders->customer->Customer_Phone }}</p>
                          @if($orders->billing_address)
                          <p style="text-align: right; margin-bottom:0">
                          <strong> Billing Address:</strong> {{ $orders->billing_address }}</p>
                          @endif
                          <p style="text-align: right; margin-bottom:0">
                            @if ($orders->shipping_address != null)
                              <strong> Shipping Address:</strong>  {{ $orders->shipping_address }}
                            @endif
                        </p>
                        </div>
                      </div>
                      <div style="justify-content: space-between;">
                        <div class="col-xs-5 pl-0">
                          <p style="margin-bottom:5px">Invoice Date : {{ $orders->SaleMaster_SaleDate }}</p>
                        </div>
                      </div>
                      <div class="table-responsive">
                            <table style="border-collapse: collapse;width: 100%;">
                              <thead style="padding:5px;background-color:#8080800d">
                                <tr>
                                    <th style="padding:5px;">SL</th>
                                    <th style="padding:5px;text-align:left">Product Name</th>
                                    <th style="padding:5px; text-align:center">Quantity</th>
                                    <th style="text-align: right; padding:5px;">Unit cost</th>
                                    <th style="text-align: right; padding:5px;">Total</th>
                                  </tr>
                              </thead>
                              <tbody>
                               
                                @foreach (\App\Models\Order::Orderdetails($orders->SaleMaster_SlNo) as $key=> $item)
                                <tr style="text-align: right; ">
                                  <td style="text-align: center; padding:5px; font-size:13px">{{ $key+1 }}</td>
                                  <td style="text-align: left; padding:5px; font-size:13px">{{ $item->product->Product_Name }}</td>       
                                  <td  style="text-align:center; padding:5px; font-size:13px">{{ $item->SaleDetails_TotalQuantity }} </td>
                                  <td style="text-align: right; padding:5px; font-size:13px">{{ $item->SaleDetails_Rate }} Tk</td>
                                  <td style="text-align: right; padding:5px; font-size:13px">{{ $item->SaleDetails_TotalAmount}} Tk</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          
                      </div>
                      <div style="padding-top: 10px">                                   
                        <p  style="text-align: right;margin-bottom:5px; margin-top:10px"><span style="font-weight:600">Sub Total :</span>  {{ $orders->SaleMaster_SubTotalAmount }} Tk</p>
                        <p  style="text-align: right;margin-bottom:15px"><span style="font-weight:600;  ">Shipping :</span>  {{ $orders->SaleMaster_Freight }} Tk</p>
                        <h4 style="text-align: right; font-weight:700"><span>Total :</span><span id="number"> {{ $orders->SaleMaster_TotalSaleAmount}}  </span> Tk</h4>                      
                      </div>                     
                  </div>
                  <div class="container-fluid w-100 mb-3 text-end" >
                    <button href="#"  onclick="printDiv('printableArea')" class="btn bg-brand btn-sm float-right ml-2"><i class="fa fa-print mr-1"></i>&nbsp;Print</button>
                  </div>
              </div>
          </div>
      </div>
    </div>
</div>
@endsection
  @push('website-js')
  
        <script>
            function printDiv(divName){
              var printContents = document.getElementById(divName).innerHTML;
              var originalContents = document.body.innerHTML;
              document.body.innerHTML = printContents;
              window.print();
              document.body.innerHTML = originalContents;
          }
        </script>
  
    @endpush
