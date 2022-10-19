@extends('layouts.website')
@section('title', 'Register')
@section('website-content')

<!-- create-account-section start -->
    <section class="create-account-section">
        <div class="container custom-container">
            <div class="row justify-content-center">
                <div class="col-md-4 py-4">
                    <div class="card login-card">
                        <div class="card-body">
                            <div class="register-form py-3">
                                <h5 class="text-center">Create An Account</h5>
                                <form action="{{route('customer.register')}}" method="post">
                                    @csrf
                                    @method('post')
                                    <div class="form-group">
                                        <label for="">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control custom-form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Full Name" id="name" autocomplete="off">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Phone No. <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control custom-form-control form-control-sm @error('phone') is-invalid @enderror" placeholder="Phone No." id="phone" autocomplete="off">
                                        @error('phone')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password" class="form-control custom-form-control form-control-sm @error('password') is-invalid @enderror" placeholder="Password" id="password" autocomplete="off">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" name="cpassword" class="form-control custom-form-control form-control-sm" placeholder="Confirm Password" id="cpassword" autocomplete="off">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-brand px-5 rounded-pill mt-3 py-1 custom-button" value="">Create An Account</button>                           
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 
   <!-- create-account-section end -->



@endsection
