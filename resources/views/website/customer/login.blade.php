@extends('layouts.website')
@section('title', 'Login')
@section('website-content')

<section class="create-account-section">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card my-4 login-card">
                    <div class="card-body">
                        <div class="py-3">
                            <h5 class="text-center mb-5">Login Your Account</h5>
                            <form action="{{route('customer.login.store')}}" method="post">
                                @csrf
                                @method('post')
        
                                <div class="form-group">
                                    <label for="">Phone No. <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control custom-form-control form-control-sm @error('phone') is-invalid @enderror" placeholder="Phone No." id="phone" autocomplete="off">
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="form-group mt-2">
                                    <label for="">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control custom-form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password" id="password" autocomplete="off">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div class="justify-content-between d-flex mt-3">
                                    <a href="{{route('customer.register.form')}}" class="btn btn-secondary mt-3 rounded-pill py-1 custom-button" value="">Register Now ?</a>   
                                    <button type="submit" class="btn bg-brand rounded-pill px-4 mt-3 custom-button py-1" value="">Login</button>                 
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
