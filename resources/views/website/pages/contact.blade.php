@extends('layouts.website')
@section('title', 'Contact Us')
@section('website-content')
<!-- contact form  -->
<section class="py-4 section-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <form action="{{ route('contact-store.website') }}" method="post">
                            @csrf
                            <div class="row">
                           
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Enter Your Name</label>
                                        <input type="text" class="form-control custom-form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Enter Email</label>
                                        <input type="email" class="form-control custom-form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control custom-form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone Number">
                                    </div>
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="subject" class="form-label">Subject</label>
                                        <input type="text" class="form-control custom-form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Subject">
                                    </div>
                                    @error('subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Message</label>
                                        <textarea name="message" id="message" cols="30" rows="3" class="form-control custom-form-control @error('message') is-invalid @enderror" placeholder="write Here ..."></textarea>
                                    </div>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <div class="d-md-block mt-3 text-center">
                                        <button class="btn bg-brand" type="submit">Send Message</button>
                                      </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>         
            <div class="col-lg-4 col-md-4 col-12 mt-md-0 mt-2">
                <div class="card custom-card">
                    <div class="card-body" style="height: 348px;">
                        <h4> {{ $content->Company_Name }} </h4>
                        <p class="pb-0 mb-0 text-uppercase text-dark font-16">ADDRESS</p>
                        <p class="pb-0 text-dark font-14">{{ $content->Repot_Heading }}</p>
          
                        <p class="pb-0 mb-0 text-uppercase text-dark font-16">PHONE</p>
                        <p class="pb-0 text-dark font-14">
                        Mobile :{{ $content->phone }}</p>
          
                        {{-- <p class="pb-0 mb-0 text-uppercase text-dark font-16">EMAIL</p>
                        <p class="pb-0 text-dark font-14">{{ $content->email }}</p> --}}
          
                        <p class="pb-0 mb-0 text-uppercase text-dark font-16">Working days</p>
                        <p class="pb-0 text-dark font-14">24/7</p> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- close contact form -->

<!-- Map -->
<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card custom-card">
                    <div class="card-body">
                        <iframe src="{{ $content->map }}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Map -->
@endsection