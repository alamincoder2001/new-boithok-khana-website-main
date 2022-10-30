<!-- start middle footer  -->
<section class="footer-middle-bg pt-5 ">
    <div class="container">
       <div class="row">
           {{-- <div class="col-md-3 col-12">
                <h5 class="text-white fw-bold footer-title"></h5>
                <a href="{{ route('home') }}"><img src="{{$domain}}uploads/company_profile_org/{{ $content->Company_Logo_org }}" alt="" class="company-logo-footer"></a>
            <a href="{{ route('home') }}"><img src="{{$domain}}uploads/company_profile_org/{{ $content->Company_Logo_org }}" alt="" class="company-logo-footer"></a>
           </div> --}}
           <div class="col-md-4 col-6">
            <h5 class="text-white fw-bold footer-title">Information Link</h5>
             <ul class="fa-ul custom-fa-ul">
                <li><a href="{{ route('about.website') }}">About Us</a></li>
                <li><a href="{{ route('contact.website') }}">Contact Us</a></li>
                <li><a href="{{ route('faq.website') }}">FAQs</a></li>
                <li><a href="{{ route('customer.login') }}">My Account</a></li>
            </ul>
           </div>

           <div class="col-md-4 col-6">
            <h5 class="text-white fw-bold footer-title">Social Link</h5>
             <ul class="fa-ul custom-fa-ul">
                <li><a href="{{ $content->facebook }}" target="_blank">Facebook</a></li>
                <li><a href="{{ $content->instagram }}" target="_blank">Instagram</a></li>
                <li><a href="{{ $content->twitter }}" target="_blank">Twitter</a></li>
                <li><a href="{{ $content->linkedin }}" target="_blank">Linkedin</a></li>
                <li><a href="{{ $content->youtube }}" target="_blank">Youtube</a></li>
            </ul>
           </div>

           <div class="col-md-4 col-12">
            <h5 class="text-white fw-bold footer-title">Address</h5>
             <ul class="fa-ul custom-fa-ul">
                <li><a href="#">{{ $content->Company_Name }}</a></li>
                <li><a href="tel:/{{ $content->phone }}">Phone: {{ $content->phone }}</a></li>
                <li><a href="">Address: {{ $content->Repot_Heading }}</a></li>
            </ul>
           </div>
    </div>
    
</section>
<!-- end middle footer  -->

<!-- start footer buttom section -->
<section class="footer-buttom-bg" style="margin-top:1px">
    <div class="container py-2">
        <div class="row">
            <div class="col-6 col-md-6">
                <div style="color: #999999"> All Rights Researved &copy; <a href="#">{{ $content->Company_Name }}</a></div>
            </div>
            <div class="col-6 col-md-6">
                <div class="text-end" style="color: #999999;font-family: sans-serif;"> Designed & Developed By: <a href="http://linktechbd.com/" target="_blank">Link-Up Technology Ltd.</a></div>
            </div>
        </div>
    </div>
</section>
<!-- end footer section -->