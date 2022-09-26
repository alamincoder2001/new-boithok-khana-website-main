@extends('layouts.website')
@section('title', 'Enter OTP Code')
@section('website-content')

<section class="create-account-section">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card my-4">
                    <div class="card-body">
                        <div class="py-3">
                            <div class="alert alert-primary d-flex align-items-center" role="alert">
                                <i class="fa-solid fa-circle-info fs-5"></i> &nbsp; &nbsp;
                                <div class="fs-12">
                                    We've sent a 4-digit OTP in your phone# {{session('phone') }}, please type PIN
                                </div>
                                {{session('otp_no') }}
                              </div>
                            <h5 class="text-center mb-3 fs-5">Enter OTP Pin</h5>
                            <form action="{{route('customer.otpverify')}}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="otp" class="form-control custom-form-control @error('otp') is-invalid @enderror" placeholder="xxxxxx" id="otp" autocomplete="off">
                                    
                                    @error('otp')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror                      
                                </div>
                                
                                @if (Session('failed'))
                                    <br>
                                    <div class="alert alert-danger text-nowrap py-1" style="font-size: 12px">
                                        !Opps Your otp isn't match 
                                    </div>
                                @endif

                                <div class="text-center mt-2">   
                                    <button type="submit" class="btn bg-brand rounded-pill px-4 mt-3 py-1 custom-button" value="">Check</button>                                                
                                </div>
                                <div class="text-center mt-3">
                                    <a href="#!" class="fs-6"><i class="fa-solid fa-rotate"></i> Resend OTP</a>   
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
