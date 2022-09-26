@extends('layouts.website')
@section('title', 'Refund Policy')
@section('website-content')
<section>
    <div class="container">
        <div class="row my-5">
            <div class="text-center">
            <h3 class="title">{{ $refund->refund_title }}</h3>
        </div>
            <div class="center">
                <div class="col-10">
                   {!! $refund->refund_details !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection