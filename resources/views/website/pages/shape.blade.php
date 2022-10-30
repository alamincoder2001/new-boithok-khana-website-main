@extends('layouts.website')
@section('title', "Our Shape")
@section('website-content')

    <section class="my-4">
        <div class="container">
            <div class="row">
                <div class="col-auto me-auto">
                    <div class="common-title">Our Management</div>
                </div>
                <div class="col-auto">

                </div>
            </div>
            <hr class="mt-2">
            <div class="row row-cols-md-4 row-cols-1 gx-2 gy-md-0 gy-3">
                @forelse ($data['shapes'] as $item)
                    <div class="col expert-food">
                        <div class="card p-2 expert_card">
                            <img src="{{$domain}}uploads/shape/{{ $item->image }}" loading="lazy" class="img-fluid" alt="">
                            <div class="py-3 text-center">
                                <h3>{{ $item->name }}</h3>
                                <h4>{{ $item->designation }}</h4>
                                <div class="social">
                                    <a href="{{ $item->facebook }}" target="_blank" class="fb"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="{{ $item->twitter }}" target="_blank" class="twitter"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="{{ $item->instagram }}" target="_blank" class="instagram"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="{{ $item->linkedin }}" target="_blank" class="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h6 class="text-danger">Management Not Found</h6>
                @endforelse

            </div>
        </div>
    </section>

@endsection
