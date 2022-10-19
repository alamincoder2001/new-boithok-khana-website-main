
@php 
$route = Route::currentRouteName();
@endphp

<header>
  <nav class="navbar navbar-expand-lg navigation-wrap">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}"><img src="{{ asset('boithok-khana.png') }}" height="40" alt=""><h3 class="text-white display-none-sm">{{ $content->Company_Name }}</h3></a>
      
      <!-- responsive -->
      <div class="display-block-sm">
        <li class="nav-item d-flex">
          @if(isset(Auth::guard('customer')->user()->Customer_SlNo))
          <a href="{{ route('customer.dashboard') }}" class="nav-link color-brand px-2">Dashboard</a> 
          @else
            <a href="{{ route('customer.login') }}" class="nav-link color-brand px-2">Login</a>
          @endif                   
          </a> <span class="text-white pt-1">|</span>
          @if(isset(Auth::guard('customer')->user()->Customer_SlNo))
          <a href="{{ route('customer.logout') }}" class=" nav-link text-danger px-2">Log Out</a> 
          @else
          <a  href="{{route('customer.register.form')}}" class="nav-link text-info px-2">Register</a>
          @endif         
        </li>
      </div>
      
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#responsiveMenu" aria-controls="responsiveMenu">
        <i class="fa-solid fa-bars text-white"></i>
      </button>

      <!-- close responsive -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link @if($route == 'home') nav-active @endif" aria-current="page" href="{{ route('home') }}">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle @if($route == 'productDetails') nav-active @endif" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Food Item
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              @foreach($category->take(15) as $item)
                <li><a class="dropdown-item" href="{{ route('categorywise', $item->ProductCategory_SlNo) }}">{{ $item->ProductCategory_Name }}</a></li>
              @endforeach
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link @if($route == 'images.website') nav-active @endif" href="{{ route('images.website') }}">Gallery</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if($route == 'shape.website') nav-active @endif" href="{{ route('shape.website') }}">Our Chef</a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if($route == 'contact.website') nav-active @endif" href="{{ route('contact.website') }}">Contact Us</a>
          </li>         
          <li class="nav-item d-flex display-none-sm">
            @if(isset(Auth::guard('customer')->user()->Customer_SlNo))
            <a href="{{ route('customer.dashboard') }}" class="nav-link color-brand @if($route == 'customer.dashboard') nav-active @endif">Dashboard</a> 
            @else
              <a href="{{ route('customer.login') }}" class="nav-link color-brand @if($route == 'customer.login') nav-active @endif">Login</a>
            @endif                   
            </a> <span class="text-white pt-1">|</span>
            @if(isset(Auth::guard('customer')->user()->Customer_SlNo))
            <a href="{{ route('customer.logout') }}" class=" nav-link text-danger @if($route == 'customer.logout') nav-active @endif">Log Out</a> 
            @else
            <a  href="{{route('customer.register.form')}}" class="nav-link text-info @if($route == 'customer.register.form') nav-active @endif">Register</a>
            @endif         
          </li>

          <li class="nav-item display-none-sm">
            <a href="#" class="position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight1" aria-controls="offcanvasRight">
              <i class="fa-solid fa-cart-arrow-down mid-icon"></i>
              <span class="position-absolute  start-100 translate-middle badge cart-top rounded-circle bg-danger" id="cart-number">
              0
              </span>
            </a> 
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- offcanvus shopping cart -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight1" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header shopping-cart-bg mb-4">
    <div class="">
      Shopping Cart
        <span class="position-absolute  badge rounded-pill bg-danger ms-3" id="cart-item"></span>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
<div class="offcanvas-body">
  <div class="container mb-4 cartHomepage">
      
  </div>
  <div class="d-flex justify-content-between">
    <span>Total</span>
    <h5 class="fw-bold" id="subtotal"></h5>
  </div>
  <div class="d-grid gap-2">
    <a href="{{ route('cart-details') }}" class="btn-view-cart text-center" type="button">View Cart</a>
  </div>
  <div class="d-grid gap-2 mt-3">
    <a class="brn-check-out text-center" href="{{ route('checkout') }}" >Check Out</a>
  </div>

</div>
</div>

<!-- Responsive Menu -->

<div class="offcanvas offcanvas-start custom-offcanvas" tabindex="-1" id="responsiveMenu" aria-labelledby="responsiveMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title text-white" id="responsiveMenuLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Product Item
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          @foreach($products as $item)
            <li><a class="dropdown-item" href="{{ route('productDetails', $item->Product_SlNo) }}">{{ $item->Product_Name }}</a></li>
          @endforeach
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('images.website') }}">Gallery</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('shape.website') }}">Our Chef</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('contact.website') }}">Contact Us</a>
      </li>         

    </ul>
  </div>
</div>
<!-- close Responsive Menu -->