@extends('layouts.website')
@section('title', "Not Found")
@section('website-content')

<section class="my-5">
    <div class="container" style="">
        <div class="row">
            <div class="col">
                <div class="card border-0">
                    <div class="card-body text-center">
                        <img src="{{ asset('uploads/error/error.png') }}" alt="" class="img-fluid" style="height:200px;width:auto">
                        <div class="alert alert-danger py-2 mt-1" role="alert">
                            <h3 class="text-center text-danger"><i class="fa-solid fa-triangle-exclamation"></i> &nbsp; Not Found At This Moment</h3>
                          </div>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection