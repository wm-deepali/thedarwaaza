@php
    use Illuminate\Support\Str;

    // Uploaded file path -> public URL (full URL ho to jaisa hai waisa)
    $img = function ($path) {
        if (blank($path)) {
            return null;
        }
        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : asset('storage/' . ltrim($path, '/'));
    };

    $siteName   = $general->site_name ?: 'The Darwaaza';
    $logoUrl    = $img($general->header_logo);
    $footerLogo = $img($general->footer_logo);
    $faviconUrl = $img($general->favicon);

    $phones = collect(explode(',', (string) $general->phone))
        ->map(fn ($p) => trim($p))
        ->filter()
        ->values();

    $contactEmail = $general->support_email ?: $general->admin_email;

    // WhatsApp: sirf digits, 10 digit ho to India code lagao
    $waDigits = preg_replace('/\D/', '', (string) $general->whatsapp);
    if (strlen($waDigits) === 10) {
        $waDigits = '91' . $waDigits;
    }
    $hasWhatsapp = strlen($waDigits) >= 10;

    $socials = [
        'facebook'  => 'fa-facebook-f',
        'instagram' => 'fa-instagram',
        'pinterest' => 'fa-pinterest-p',
        'twitter'   => 'fa-twitter',
        'linkedin'  => 'fa-linkedin-in',
        'youtube'   => 'fa-youtube',
    ];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Title, description, keywords, robots, canonical, OG, Twitter, JSON-LD, custom head scripts --}}
    @include('partials.seo')

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZD6RGZPK8W"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'G-ZD6RGZPK8W');
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    @if($faviconUrl)
        <link rel="icon" href="{{ $faviconUrl }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>

<body>
    @if (!empty($seo?->body_scripts))
        {!! $seo->body_scripts !!}
    @endif

    <div class="boxed_wrapper">

        <header class="main-header">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5">
                            <ul class="links-nav clearfix">
                                <li>
                                    <a href="https://goo.gl/maps/ppURxTJ1ni8yc4EKA" target="_blank">
                                        <span class="icon-signs"></span> Delivered To Uttar Pradesh And Near By Areas..
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <ul class="d-flex">
                                <li>
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('assets/images/google-reviews.png') }}" width="50%"
                                            alt="Google Reviews">
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <img src="{{ asset('assets/images/just-dial-reviews.png') }}" width="50%"
                                            alt="Justdial Reviews">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="social">
                                @foreach($socials as $field => $icon)
                                    @if(filled($general->{$field}))
                                        <li>
                                            <a href="{{ $general->{$field} }}" target="_blank" rel="noopener"
                                                aria-label="{{ ucfirst($field) }}">
                                                <i class="fa-brands {{ $icon }}"></i>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <a href="{{ route('enquiry') }}" class="enq-btn">Send Enquiry</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header-upper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="pull-left logo-outer">
                                @if($logoUrl)
                                    <div class="logo">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ $logoUrl }}" alt="{{ $siteName }}" title="{{ $siteName }}">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 marg">
                            @if($hasWhatsapp)
                                <div class="midd-header">
                                    <span>Have Questions? </span>
                                    <a href="https://api.whatsapp.com/send?phone={{ $waDigits }}&amp;text=Hi"
                                        target="_blank" rel="noopener">
                                        <img src="{{ asset('assets/images/whatsapp.png') }}" alt="whatsapp" width="15%">
                                        {{ $general->whatsapp }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-3 marg">
                            <div class="search-box">
                                <input class="search-input" type="text" placeholder="Search something..">
                                <button class="search-btn"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mill-sec-img">
                                <img src="{{ asset('assets/images/Price.jpg') }}" width="75%" alt="Price">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="mainmenu-wrapper stricky">
            <div class="container-fluid">
                <div class="menu-bg clearfix">
                    <nav class="mainmenu-holder">
                        <div class="nav-header">
                            <ul class="navigation">
                                <li><a href="{{ url('/') }}">HOME</a></li>
                                <li>
                                    <a href="{{ route('about') }}">ABOUT US</a>
                                    <ul class="submenu">
                                        <li><a href="{{ route('strength') }}">Our Strength</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);">PRODUCTS</a>
                                    <ul class="submenu">
                                        @foreach($navCategories as $navCategory)
                                            @include('partials.nav-category', ['category' => $navCategory, 'level' => 0])
                                        @endforeach
                                    </ul>
                                </li>
                                <li><a href="{{ asset('pdf/thedarwaaza.pdf') }}" target="_blank">Brochure</a></li>
                                <li><a href="{{ route('contact') }}">CONTACT US</a></li>
                            </ul>
                        </div>
                        <div class="nav-footer hidden-lg">
                            <ul>
                                <li>
                                    <button class="menu-expander"><i class="fa fa-list-ul"></i></button>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </section>

        @yield('content')

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="inner-title">
                            @if($footerLogo)
                                <a href="{{ url('/') }}">
                                    <img src="{{ $footerLogo }}" alt="{{ $siteName }}" style="max-width:180px;margin-bottom:12px">
                                </a>
                            @endif
                            @if(filled($general->footer_description))
                                <h3>Our Solution</h3>
                                <p>{!! nl2br(e($general->footer_description)) !!}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inner-title">
                            <h3>Quick Link</h3>
                            <ul class="hei">
                                <li><i class="fas fa-arrow-right" aria-hidden="true"></i> <a
                                        href="{{ url('/') }}">Home</a></li>
                                <li><i class="fas fa-arrow-right" aria-hidden="true"></i> <a
                                        href="{{ route('about') }}">About us</a></li>
                                <li><i class="fas fa-arrow-right" aria-hidden="true"></i> <a
                                        href="{{ asset('pdf/thedarwaaza.pdf') }}" target="_blank">Brochure</a></li>
                                <li><i class="fas fa-arrow-right" aria-hidden="true"></i> <a
                                        href="{{ route('contact') }}">Contact us</a></li>
                                <li><i class="fas fa-arrow-right" aria-hidden="true"></i> <a
                                        href="{{ route('enquiry') }}">Enquiry</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="inner-title">
                            <h3>Category</h3>
                            <ul class="hei">
                                @foreach($navCategories as $navCategory)
                                    <li>
                                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                        <a href="{{ route('category.show', $navCategory->slug) }}">{{ $navCategory->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="inner-title add">
                            <h3>CONTACT US</h3>
                            <ul>
                                @if(filled($general->business_address))
                                    <li>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <span>Address: <br></span>
                                        {!! nl2br(e($general->business_address)) !!}
                                    </li>
                                @endif

                                @if($phones->isNotEmpty())
                                    <li>
                                        <i class="fa-solid fa-phone"></i>
                                        <span>Mobile:- <br></span>
                                        @foreach($phones as $phone)
                                            <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a>@if(!$loop->last), @endif
                                        @endforeach
                                    </li>
                                @endif

                                @if($contactEmail)
                                    <li>
                                        <i class="fa-solid fa-envelope"></i>
                                        <span>Email:- <br></span>
                                        <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                                    </li>
                                @endif

                                @if(filled($general->business_hours))
                                    <li>
                                        <i class="fa-regular fa-clock"></i>
                                        <span>Business Hours:- <br></span>
                                        {!! nl2br(e($general->business_hours)) !!}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-text">
                <p>
                    @if(filled($general->footer_copyright))
                        {{ $general->footer_copyright }} |
                    @endif
                    <a href="https://keywordindia.com/">Keyword India Network Pvt. Ltd.</a>
                </p>
            </div>
        </footer>

        @if($hasWhatsapp)
            <!-- Button trigger modal -->
            <button type="button" class="popup-btn" data-toggle="modal" data-target="#exampleModal">
                <img src="{{ asset('assets/images/doors_whatsapp.jpg') }}" alt="WhatsApp">
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div class="popup-detail">
                                <div class="popup-img">
                                    <img src="{{ asset('assets/images/popup.jpg') }}" alt="">
                                </div>
                                <div class="popup-text">
                                    <h2>Get More Design</h2>
                                    <p>Idea On Whats app</p>
                                    <a href="https://api.whatsapp.com/send?phone={{ $waDigits }}&text=Hi"
                                        target="_blank" rel="noopener">
                                        <i class="fa-brands fa-whatsapp"></i> Start chat
                                    </a>
                                    <span class="text-red blink-hard">We Are Online</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Scroll Top Button -->
        <button class="scroll-top tran3s color2_bg">
            <span class="fa fa-angle-up"></span>
        </button>

    </div>

    <!-- jQuery js -->
    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- jQuery ui js -->
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <!-- owl carousel js -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- jQuery validation -->
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <!-- google map -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>
    <script src="{{ asset('assets/js/gmap.js') }}"></script>
    <!-- mixit up -->
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mixitup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.fitvids.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <!-- revolution slider js -->
    <script src="{{ asset('assets/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
    <script src="{{ asset('assets/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
    <!-- fancy box -->
    <script src="{{ asset('assets/js/jquery.fancybox.pack.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.polyglot.language.switcher.js') }}"></script>
    <script src="{{ asset('assets/js/nouislider.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.bootstrap-touchspin.js') }}"></script>
    <script src="{{ asset('assets/js/SmoothScroll.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countTo.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.flexslider.js') }}"></script>
    <script src="{{ asset('assets/js/imagezoom.js') }}"></script>
    <!-- theme custom js -->
    <script id="map-script" src="{{ asset('assets/js/default-map.js') }}"></script>
    <script src="https://kit.fontawesome.com/d97b87339f.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    @stack('scripts')
</body>

</html>