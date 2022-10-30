<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Free Web tutorials">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $content->Company_Name }} | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{$domain}}uploads/company_profile_org/{{ $content->Company_Logo_org }}" />
    <link rel="stylesheet" href="{{asset('website')}}/css/bootstrap.min.css">
    <link href="{{ asset('website/css/toastr.min.css') }}" rel="stylesheet" id="galio-skin">
    <link rel="stylesheet" href="{{asset('website')}}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('website')}}/css/owl.theme.default.css">
    <!-- view box -->
    <link rel="stylesheet" href="{{ asset('website/css/viewbox.css') }}">
    <link rel="stylesheet" href="{{asset('website')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('website')}}/css/responsive.css">
    @stack('website-css')

    <style>
        * {
            font-size: 14px;
        }

        .owl-prev {
            display: none;
        }
        .disabled {
            display: none !important;
        }
    </style>
</head>

<body>
    @include('partials.website_header')
    <!-- pre-loader -->
    <div class="loader_bg">
        <div class="loader"></div>
    </div>
    <!-- close pre-loader -->
    @yield('website-content')

    <div id="scroll-cart" class="display-block-sm">
        <div class="cart-fixed">
            <div class="card custom-card bg-brand">
                <div class="card-body pe-4 pb-2 text-center">
                    <div class="cart-open">
                        <a href="#" class="position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight1" aria-controls="offcanvasRight">
                            <i class="fa-solid fa-cart-arrow-down mid-icon"></i>
                            <span class="position-absolute  start-100 translate-middle badge cart-top rounded-circle bg-danger" id="cart-number-responsive">
                                {{ \Cart::getContent()->count() }}
                            </span>
                        </a>
                    </div>
                    <span class="text-center fs-14 fw-bold text-white"><span id="cart-subtotal-responsive"></span></span>
                </div>
            </div>
        </div>
    </div>

    @include('partials.website_footer')

    <script src="{{asset('website')}}/js/jquery.min.js"></script>
    <script src="{{asset('website')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('website')}}/js/all.min.js"></script>
    <script src="{{asset('website')}}/js/owl.carousel.min.js"></script>
    <script src="{{asset('website')}}/js/owl.carousel.min.js"></script>
    <!-- view box -->
    <script src="{{ asset('website/js/viewbox.min.js') }}"></script>
    <script src="{{ asset('website/js/toastr.min.js') }}"></script>
    <script src="{{asset('website/js/bootstrap3-typeahead.min.js')}}"></script>
    <script src="{{asset('website')}}/js/custom.js"></script>
    <script>
        $(function() {
            $('.image-link').viewbox();
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    @stack('website-js')
    <script>
        var domain = "{{$domain}}"
        setTimeout(function() {
            $('.loader_bg').fadeToggle();
        }, 1000);
    </script>

    <script>
        function increment() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('number').value = value;
        }

        function decrement() {
            var value = parseInt(document.getElementById('number').value, 10);
            if (value >= 2) {
                value = isNaN(value) ? 0 : value;
                value--;
                document.getElementById('number').value = value;
            }
        }
    </script>

    <script>
        @if(Session::has('cart'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('cart') }}");
        @endif

        @if(Session::has('update'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('update') }}");
        @endif

        @if(Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('message') }}");
        @endif
        @if(Session::has('success'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('remove'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('remove') }}");
        @endif

        @if(Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
        @endif
    </script>

    <script>
        var baseUri = "{{ url('/') }}"
        $('.keyword').typeahead({
            minLength: 1,
            source: function(keyword, process) {
                return $.get(`${baseUri}/get_suggestions/${keyword}`, function(data) {
                    return process(data);
                });
            },
            updater: function(item) {
                $(location).attr('href', '/search?q=' + item);
                return item;
            }
        });
    </script>

    <script>
        $(".owl-prev").html('<i class="fa fa-chevron-left"></i>');
        $(".owl-next").html('<i class="fa fa-chevron-right"></i>');
    </script>
    <script>
        function quickOrder() {
            let txtId = $("#txtId").val();
            let quantity = $("#quantity").val();
            $.ajax({
                url: "{{ route('add.cart') }}",
                type: "POST",
                data: {
                    txtId: txtId,
                    quantity: quantity
                },
                success: function(res) {
                    if (res.result = 'true') {
                        toastr.success("Successfully Added To Cart");
                        cartHomePage();
                    }
                },
                error: function(data) {
                    if (res.result = 'false') {
                        toastr.error("Failed Added To Cart");
                    }
                }

            });
        }
    </script>

    <script>
        cartHomePage();

        function cartHomePage() {
            $.ajax({
                url: "{{route('cart.alldata')}}",
                type: "get",
                dataType: "json",
                success: function(res) {
                    $('#cart-item').text(res.total_item);
                    $('#cart-number').text(res.total_item);
                    $('#cart-number-responsive').text(res.total_item);
                    $('#cart-subtotal-responsive').text('৳ ' + res.total_amount);
                    $('#cart-itemhover').text(res.total_item);
                    $('#subtotal').text('৳ ' + res.total_amount);
                    $('#cart-subtotal').text('৳ ' + res.total_amount);
                    var data = '';
                    var quickdata = '';
                    quickdata += '<thead>';
                    quickdata += '<tr>';
                    quickdata += '<th>Food</th>';
                    quickdata += '<th>Qty</th>';
                    quickdata += '<th>Price</th>';
                    quickdata += '</tr>';
                    quickdata += '</thead>';
                    $.each(res.cart, function(key, value) {

                        data += '<div class="cart-item-single d-flex my-2">';
                        data += '<div class="mx-2">';
                        data += '<a href="#">';
                        data += '<img src="' + value.attributes.image + '" alt="" class="offcanvas-cart-image">';
                        data += '</a>';
                        data += '</div>';
                        data += '<div class="cart-content">';
                        data += '<h5><a href="#" class="product-title" style="min-height:25px">' + value.name + '</a></h5>';
                        // data+='<p class="mb-0"><span>HP</span>/ <span>Red</span></p>';
                        data += '<p class="mb-0">' + value.quantity + ' X ' + value.price + ' TK</p>';

                        data += '</div>';
                        data += '<div class="cart-remove mx-1" onclick="cartDelete(' + value.id + ')" title="Remove From Cart">';
                        data += '<i class="fa-regular fa-circle-xmark remove-icon"></i>';
                        data += '</div>';
                        data += '</div>';

                        //quick data
                        quickdata += '<tbody>';
                        quickdata += '<tr>';
                        quickdata += '<td><strong>' + value.name + '</strong> </td>';
                        quickdata += '<td><strong>' + value.quantity + '</strong> </td>';
                        quickdata += '<td><strong>' + value.price + '</strong> </td>';
                        quickdata += '</tr>';

                    });
                    quickdata += '<tr>';
                    quickdata += '<td colspan="2" class="text-center"><strong>Grand Total: </strong> </td>';
                    quickdata += '<td style="white-space:nowrap"><strong>TK. ' + res.total_amount + '</strong> </td>';
                    quickdata += '</tr>';
                    quickdata += '</tbody>';
                    $('.Quickdata').html(quickdata);
                    $('.cartHomepage').html(data);

                }
            });
        }
    </script>

    <script>
        function cartDelete(id) {
            $.ajax({
                url: "{{ asset('/') }}" + 'cart-remove/' + id,
                method: "get",
                success: function(res) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                    }
                    toastr.success('Successfully Removed');
                    cartHomePage();
                    cartPage();
                    shippingPage(0);

                }
            })
        }
    </script>

    <script>
        function cartAjax(id) {
            $.ajax({
                url: "{{ asset('/') }}" + 'add-to-cart/' + id,
                method: "get",
                success: function(res) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                    }
                    toastr.success('Cart Added Successfully');
                    $('#cart-item').text(res.total_item);
                    $('#cart-number').text(res.total_item);
                    $('#cart-itemhover').text(res.total_item);
                    $('#subtotal').text('৳ ' + res.total_amount);
                    $('#cart-subtotal').text('৳ ' + res.total_amount);
                    $('#cart-number-responsive').text(res.total_item);
                    $('#cart-subtotal-responsive').text('৳ ' + res.total_amount);

                    var data = '';
                    $.each(res.cart, function(key, value) {
                        data += '<div class="cart-item-single d-flex">';
                        data += '<div class="mx-2">';
                        data += '<a href="#">';
                        data += '<img src="' + value.attributes.image + '" alt="" class="offcanvas-cart-image">';
                        data += '</a>';
                        data += '</div>';
                        data += '<div class="cart-content">';
                        data += '<h5><a href="#">' + value.name + '</a></h5>';
                        // data+='<p class="mb-0"><span>'+value.attributes.size_name+'</span>/ <span>'+value.attributes.color_name+'</span></p>';
                        data += '<p class="mb-0">' + value.quantity + ' X ' + value.price + ' TK</p>';

                        data += '</div>';
                        data += '<div class="cart-remove mx-1" onclick="cartDelete(' + value.id + ')">';
                        data += '<i class="fa-regular fa-circle-xmark remove-icon"></i>';
                        data += '</div>';
                        data += '</div>';
                    });

                    $('.cartHomepage').html(data);
                }
            })

        }
    </script>

    <script>
        wishCount();

        function wishCount() {
            $.ajax({
                url: "{{ asset('/') }}" + 'wishcount',
                method: "get",
                success: function(res) {
                    $('#wish-count').text(res);
                }
            })
        }
    </script>

    <script>
        function wishAjax(id) {
            $.ajax({
                url: "{{ asset('/') }}" + 'wishlist/' + id,
                method: 'get',
                success: function(res) {

                    $('#wish-count').text(res.wishlist);

                    if (res.result == 'true') {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                        }
                        toastr.success('Successfully Added to wishlist');
                    } else if (res.result == 'exists') {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                        }
                        toastr.error('Already Exists');
                    } else {
                        toastr.options = {
                            "closeButton": true,
                            "progressBar": true,
                        }
                        toastr.error('Please Login First');
                    }
                }
            })
        }
    </script>

    <script>
        $(".Increment").on("click", (e) => {
            var inputvalue = $(".ShowIncrementDecrement").val();
            $(".ShowIncrementDecrement").val(inputvalue + 1)
        })
    </script>
</body>

</html>