@extends('layouts.website')
@section('title', 'About Us')
@section('website-content')
<section>
    <div class="container">
        <div class="row my-5">
            <div class="text-center">
            <h3 class="title">About Us</h3>
        </div>
            <div class="center">
                <div class="col-10">
                    {!! $content->about_us !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection