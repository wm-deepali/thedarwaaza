@extends('layouts.app')

@section('title', 'Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow | The Darwaaza')
@section('meta_description', 'The Darwaaza is Leading Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow. Get Here door at best price')
@section('meta_keywords', 'Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow')
@section('canonical', 'https://thedarwaaza.com')

@section('content')

<!-- Carousel Default -->
<section class="carousel-default">
    <div id="carousel-default" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carousel-default" data-slide-to="0" class=""></li>
            <li data-target="#carousel-default" data-slide-to="1" class=""></li>
            <li data-target="#carousel-default" data-slide-to="2" class="active"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="{{ asset('assets/images/slider/1.jpg') }}" alt="Modern Designer Door Manufacturing In India">
                <div class="carousel-caption">
                    <h3>Modern Designer Door Manufacturing In India</h3>
                    <p>Customized And Handcrafted Doors In All Price Ranges</p>
                </div>
            </div>
            <div class="item">
                <img src="{{ asset('assets/images/slider/2.jpg') }}" alt="The Darwaaza">
                <div class="carousel-caption">
                    <h3>Old Ways Won't <br>Open New Door </h3>
                </div>
            </div>
            <div class="item">
                <img src="{{ asset('assets/images/slider/3.jpg') }}" alt="The Darwaaza">
                <div class="carousel-caption">
                    <h3> <br> </h3>
                </div>
            </div>
        </div>
        <a class="left carousel-control" href="#carousel-default" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-default" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>
<!-- /end Carousel Default -->

<section id="quality">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="quality-texr">
                    <img src="{{ asset('assets/images/manufacture.png') }}" alt="Direct Manufacturer">
                    <h3>Direct Manufacturer</h3>
                    <p>We are not traders we are direct manufacturer.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quality-texr">
                    <img src="{{ asset('assets/images/delivery.png') }}" alt="Fast Delivery">
                    <h3>Fast Delivery</h3>
                    <p>Within 7 days delivery.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="quality-texr">
                    <img src="{{ asset('assets/images/bulk.png') }}" alt="Bulk Orders">
                    <h3>Bulk Orders</h3>
                    <p>This website is only for enquire and bulk orders. We do not sell our product online on website.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="pro-detail">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="smart-doors-img">
                    <img src="{{ asset('assets/images/smart-door.jpg') }}" alt="Smart Doors Design">
                </div>
                <div class="smart-doors-text">
                    <h3>Smart Doors <br> Design </h3>
                    <a href="javascript:void(0);">View All</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="smart-doors-img">
                    <img src="{{ asset('assets/images/front-doors-design.jpg') }}" alt="Front Doors Design">
                </div>
                <div class="smart-doors-text">
                    <h3>Front Doors <br> Design </h3>
                    <a href="javascript:void(0);">View All</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="smart-doors-img">
                    <img src="{{ asset('assets/images/double-door-design-1.jpg') }}" alt="Double Doors Design">
                </div>
                <div class="smart-doors-text">
                    <h3>Double Doors <br> Design </h3>
                    <a href="javascript:void(0);">View All</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="smart-doors-img">
                    <img src="{{ asset('assets/images/sliding-doors-design.jpg') }}" alt="Sliding Doors Design">
                </div>
                <div class="smart-doors-text">
                    <h3>Sliding Doors <br>Design </h3>
                    <a href="javascript:void(0);">View All</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="top-seller">
    <div class="container">
        <h2>Top Seller Doors</h2>
        <div class="row">
            <div class="col-md-3">
                <div class="seler-sec">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/images/product/interior-smart.jpg') }}" alt="Interior Smart Doors">
                        <p>Interior Smart Doors</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="seler-sec">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/images/product/front-door.jpg') }}" alt="Front Door Glass">
                        <p>Front Door Glass</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="seler-sec">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/images/product/exterior-double-doors.jpg') }}" alt="Exterior Double Doors">
                        <p>Exterior Double Doors</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="seler-sec">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('assets/images/product/sliding-glass-doors.jpg') }}" alt="Sliding Glass Doors">
                        <p>Sliding Glass Doors</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="wood-door">
    <div class="container">
        <h2>Our Products</h2>
        <div class="row">
            <div class="col-md-3">
                <a href="{{ url('membrane-door-pro.html') }}">
                    <div class="pro-sec">
                        <img src="{{ asset('assets/images/product/door.jpg') }}" alt="Door">
                        <div class="caption"><h1>Door</h1></div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('wpc.html') }}">
                    <div class="pro-sec">
                        <img src="{{ asset('assets/images/product/door-frames.jpg') }}" alt="Frames">
                        <div class="caption"><h1>Frames</h1></div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('ss.html') }}">
                    <div class="pro-sec">
                        <img src="{{ asset('assets/images/product/vanities.jpg') }}" alt="Vanities">
                        <div class="caption"><h1>Vanities</h1></div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('wooden-temple.html') }}">
                    <div class="pro-sec">
                        <img src="{{ asset('assets/images/product/temple.jpg') }}" alt="Temple">
                        <div class="caption"><h1>Temple</h1></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="coll-sent">
                <div class="col-md-3">
                    <a href="{{ url('ply-board.html') }}">
                        <div class="pro-sec">
                            <img src="{{ asset('assets/images/product/plywood.jpg') }}" alt="Ply">
                            <div class="caption"><h1>ply</h1></div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('jaali.html') }}">
                        <div class="pro-sec">
                            <img src="{{ asset('assets/images/product/jaali.jpg') }}" alt="Jaali">
                            <div class="caption"><h1>Jaali</h1></div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ url('shelf.html') }}">
                        <div class="pro-sec">
                            <img src="{{ asset('assets/images/product/shelf.jpg') }}" alt="Shelf">
                            <div class="caption"><h1>Shelf</h1></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="brochure">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="padding: 0px">
                <img src="{{ asset('assets/images/brochure.jpg') }}" alt="Brochure">
            </div>
            <div class="col-md-6 brochure-text">
                <h2>LOOKING FOR <br>A UNIQUE DOOR? </h2>
                <p>You will love our wide range of products from Saina Doors.</p>
                <a href="{{ asset('pdf/brouchure.pdf') }}" target="_blank">Download Brochure</a>
            </div>
        </div>
    </div>
</section>

<section id="why-choos">
    <div class="container">
        <h2>Why Choose Us</h2>
        <p>Due to our strong commitment to the services we offer, we have already raised the bar for other retailers in the sector. We are one of the few retailers who are on top of their game and stand out from the competition.</p>
        <div class="row">
            <div class="col-md-4">
                <div class="why-text">
                    <img src="{{ asset('assets/images/machines.png') }}" alt="Technical Machines">
                    <h3>TECHNICAL MACHINES</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-text">
                    <img src="{{ asset('assets/images/customers.png') }}" alt="10000+ Customers">
                    <h3>10000+ CUSTOMERS</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-text">
                    <img src="{{ asset('assets/images/sell-out.png') }}" alt="10000+ Door Sell Out">
                    <h3>10000+ DOOR SELL OUT</h3>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-section" id="form-sec">
    <div class="container">
        <h2>Stay In Touch</h2>
        <p>For fast service and unbeatable prices, fill out the request below and well get back to <br> you with quotes for available options. </p>
        <div class="row coll-sent">
            <div class="column form-column col-md-8">
                <div class="form-box default-form">
                    <div class="default-form">
                        {{-- TODO: point this to your own route/controller (old action was a demo URL) --}}
                        <form action="#" method="POST" class="home-contact-form contact-form select-form">
                            @csrf
                            <div class="row clearfix">
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="username" value="{{ old('username') }}" placeholder="Your Name *" required>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Your Mail *" required>
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                                </div>
                                <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                    <button type="submit" class="thm-btn">submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection