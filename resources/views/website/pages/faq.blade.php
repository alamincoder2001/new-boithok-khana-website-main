@extends('layouts.website')
@section('title', 'FAQ')
@section('website-content')
<section>
    <div class="container">
        <div class="row my-5">
            <div class="text-center">
            <h3 class="title">FAQ</h3>
        </div>
            <div class="center">
                <div class="col-10">
                    {!! $content->faq !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection