@extends('layouts.website')
@section('title', 'Your Mobile No')
@section('website-content')

<section class="create-account-section">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card my-4">
                    <div class="card-body">
                        <div class="py-3">
                            <h5 class="text-center mb-3 fs-5">Enter Your Phone No</h5>
                            <form action="{{route('customer.sendotp')}}" method="post">  
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control custom-form-control @error('phone') is-invalid @enderror" placeholder="01*********" id="phone" autocomplete="off">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-center mt-2">   
                                    <button type="submit" class="btn bg-brand rounded-pill px-4 mt-3 py-1 custom-button" value="">Get OTP</button>                                                
                                </div>
                                <div class="text-center mt-3">
                                    <a href="{{route('customer.register.form')}}" class="fs-6">Register Now ?</a>   
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
