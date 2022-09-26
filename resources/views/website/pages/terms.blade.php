@extends('layouts.website')
@section('title', 'Terms & Condition')
@section('website-content')
<section>
    <div class="container">
        <div class="row my-5">
            <div class="text-center">
            <h3 class="title">{{ $terms->trams_condition_title }}</h3>
        </div>
            <div class="center">
                <div class="col-10">
                    {!! $terms->trams_condition !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection