@extends('layouts.app')

@php
    $siteName = $general->site_name;
@endphp

@section('title', 'Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow' . ($siteName ? ' | ' . $siteName : ''))
@section('meta_description', 'The Darwaaza is Leading Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow. Get Here door at best price')
@section('meta_keywords', 'Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow')
@section('canonical', url('/'))

@section('content')

    @if($sliders->isNotEmpty())
        <!-- Carousel Default -->
        <section class="carousel-default">
            <div id="carousel-default" class="carousel slide" data-ride="carousel">
                @if($sliders->count() > 1)
                    <ol class="carousel-indicators">
                        @foreach($sliders as $slide)
                            <li data-target="#carousel-default" data-slide-to="{{ $loop->index }}"
                                class="{{ $loop->first ? 'active' : '' }}"></li>
                        @endforeach
                    </ol>
                @endif

                <div class="carousel-inner" role="listbox">
                    @foreach($sliders as $slide)
                        <div class="item {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ $slide->image_url }}" alt="{{ strip_tags($slide->title) ?: $siteName }}">
                            @if(filled($slide->title) || filled($slide->subtitle))
                                <div class="carousel-caption">
                                    @if(filled($slide->title))
                                        <h3>{!! nl2br(e($slide->title)) !!}</h3>
                                    @endif
                                    @if(filled($slide->subtitle))
                                        <p>{{ $slide->subtitle }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if($sliders->count() > 1)
                    <a class="left carousel-control" href="#carousel-default" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel-default" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
        </section>
        <!-- /end Carousel Default -->
    @endif

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
                        <p>This website is only for enquire and bulk orders. We do not sell our product online on website.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($features->isNotEmpty())
        <section id="pro-detail">
            <div class="container-fluid">
                <div class="row">
                    @foreach($features as $feature)
                        <div class="col-md-3">
                            <div class="smart-doors-img">
                                <img src="{{ $feature->image_url }}" alt="{{ strip_tags($feature->title) }}">
                            </div>
                            <div class="smart-doors-text">
                                <h3>{!! nl2br(e($feature->title)) !!}</h3>
                                <a href="{{ $feature->link_url }}">View All</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($topSellers->isNotEmpty())
        <section id="top-seller">
            <div class="container">
                <h2>Top Seller Doors</h2>
                <div class="row">
                    @foreach($topSellers as $item)
                        <div class="col-md-3">
                            <div class="seler-sec">
                                <a href="{{ $item->link_url }}">
                                    <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                                    <p>{{ $item->title }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($categories->isNotEmpty())
        <section id="wood-door">
            <div class="container">
                <h2>Our Products</h2>

                @foreach($categories->chunk(4) as $chunk)
                    <div class="row">
                        @if($chunk->count() < 4)
                            <div class="coll-sent">
                        @endif

                            @foreach($chunk as $category)
                                <div class="col-md-3">
                                    <a href="{{ url($category->slug) }}">
                                        <div class="pro-sec">
                                            @if($category->image_url)
                                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}">
                                            @endif
                                            <div class="caption">
                                                <h1>{{ $category->name }}</h1>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                            @if($chunk->count() < 4)
                                </div>
                            @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <section id="brochure">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6" style="padding: 0px">
                    <img src="{{ asset('assets/images/brochure.jpg') }}" alt="Brochure">
                </div>
                <div class="col-md-6 brochure-text">
                    <h2>LOOKING FOR <br>A UNIQUE DOOR? </h2>
                    <p>You will love our wide range of products from Saina Doors.</p>
                    <a href="{{ asset('assets/pdf/thedarwaza.pdf') }}" target="_blank">Download Brochure</a>
                </div>
            </div>
        </div>
    </section>

    <section id="why-choos">
        <div class="container">
            <h2>Why Choose Us</h2>
            <p>Due to our strong commitment to the services we offer, we have already raised the bar for other retailers in
                the sector. We are one of the few retailers who are on top of their game and stand out from the competition.
            </p>
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
            <p>For fast service and unbeatable prices, fill out the request below and we'll get back to <br> you with quotes
                for available options. </p>

            <div class="row coll-sent">
                <div class="column form-column col-md-8">
                    <div class="form-box default-form">
                        <div class="default-form">

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled" style="margin:0;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('enquiry.submit') }}" method="POST"
                                class="home-contact-form contact-form select-form">
                                @csrf
                                <input type="hidden" name="form_type" value="home">
                                <input type="hidden" name="form_botcheck" value="">

                                <div class="row clearfix">
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="form_name" value="{{ old('form_name') }}"
                                            placeholder="Your Name *" required>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <input type="email" name="form_email" value="{{ old('form_email') }}"
                                            placeholder="Your Mail *" required>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="form_phone" value="{{ old('form_phone') }}"
                                            placeholder="Phone Number">
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

@if(session('success') || $errors->any())
    @push('scripts')
        <script>
            document.getElementById('form-sec')?.scrollIntoView({ behavior: 'smooth' });
        </script>
    @endpush
@endif