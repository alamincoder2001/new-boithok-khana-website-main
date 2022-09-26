@extends('layouts.website')
@section('title','Image Gallery')
@section('website-content')
<!-- Photo galary -->
<section class="my-4">
    <div class="container">
      <div class="row">
        <div class="col-auto me-auto">
            <div class="common-title">Photo Gallery </div>
        </div>
        <div class="col-auto">

        </div>
      </div>
      <hr class="mt-2">
      <div class="row">
        <div class="col-12">
          <div class="scrolling-pagination">
            <div class="row row-cols-md-5 row-cols-2 g-1">
                @foreach ($images as $item)
                <div class="col">                   
                    <div class="card">
                      <div>
                        <a href="http://localhost:84/uploads/imageGallery/{{ $item->image }}" class="image-link" title="{{ $item->title }}"><img src="http://localhost:84/uploads/imageGallery/{{ $item->image }}" alt="" class="gallary-image" title="{{ $item->title }}"></a>
                      </div>
                      <div class="card-body">
                        <p class="card-text image-title">{{ $item->title }}</p>
                      </div>
                    </div>
                  </div> 
                @endforeach    
                {{ $images->links() }}         
            </div>
        </div>
      </div>
    </div>
  </section>
  <!-- close Photo galary -->
@endsection