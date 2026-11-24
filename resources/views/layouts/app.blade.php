<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'The Darwaaza')</title>
    <meta name="description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    <!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicons/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicons/favicon-16x16.png') }}" sizes="16x16">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>

<body>
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
                                <li><a href="https://www.facebook.com/TheDarwaaza?mibextid=ZbWKwL"><i
                                            class="fa fa-facebook"></i></a></li>
                                <li><a href="https://pin.it/2iNLhCj"><i class="fa fa-pinterest"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
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
                                <div class="logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ asset('assets/images/logo/logo.png') }}" alt="The Darwaaza"
                                            title="The Darwaaza">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 marg">
                            <div class="midd-header">
                                <span>Have Questions? </span>
                                <a href="https://api.whatsapp.com/send?phone=9696333549&amp;text=Hi" target="_blank">
                                    <img src="{{ asset('assets/images/whatsapp.png') }}" alt="whatsapp" width="15%">
                                    +91-9696333549
                                </a>
                            </div>
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
                            <h3>Our Solution</h3>
                            <p>We're a Lucknow (Uttar Pradesh) based industry with two manufacturing units. We have
                                already set our standards high from other retailers in the industry due to the strong
                                commitment to the service we provide, we are one of the few retailers who are on top of
                                their business, standing out from the others. We are still growing in this industry and
                                want to become one of the largest retailers in the designer doors industry.</p>
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
                                        href="{{ asset('pdf/brouchure.pdf') }}" target="_blank">Brochure</a></li>
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
                                        <a href="{{ url($navCategory->slug) }}">{{ $navCategory->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="inner-title add">
                            <h3>CONTACT US</h3>
                            <ul>
                                <li>
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <span>Address: <br></span>
                                    5/ 626 Gomtinagar Vistar Shaheed Path Near Sadar Tehsil Lucknow 226010
                                </li>
                                <li>
                                    <i class="fa-solid fa-phone"></i>
                                    <span>Mobile:- <br></span>
                                    8423437500, 9696333549, 9415116688, 8858464795
                                </li>
                                <li>
                                    <i class="fa-solid fa-envelope"></i>
                                    <span>Email:- <br></span>
                                    thehamam99@gmail.com
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-text">
                <p>Copyright © 2023 <strong>The Hamam Local</strong> | All Right Reserved |
                    <a href="https://keywordindia.com/">Keyword India Network Pvt. Ltd.</a>
                </p>
            </div>
        </footer>

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
                                <a href="https://api.whatsapp.com/send?phone=+919696333549&text=Hi">
                                    <i class="fa-brands fa-whatsapp"></i> Start chat
                                </a>
                                <span class="text-red blink-hard">We Are Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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