@extends('layouts.app')

@section('title', 'Contact' . ($general->site_name ? ' | ' . $general->site_name : ''))
@section('meta_description', 'Contact' . ($general->site_name ? ' | ' . $general->site_name : ''))
@section('meta_keywords', 'Contact' . ($general->site_name ? ' | ' . $general->site_name : ''))
@section('canonical', url('/contact'))

@section('content')

<div class="inner-banner has-base-color-overlay text-center" style="background: url({{ asset('assets/images/background/inner-page.jpg') }});">
    <div class="container">
        <div class="box">
            <h3>contact us</h3>
        </div>
    </div>
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="pull-left">
                <ul class="list-inline link-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('contact') }}">contact us</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="single_contact_form">
    <div class="container">
        <div class="row">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12">
                <div class="section-title">
                    <h3>Get in Touch</h3>
                    <span class="decor"></span>
                </div>
                <div class="accordion-box">
                    <div class="accordion animated out" data-delay="0" data-animation="fadeInUp">
                        <div class="acc-content collapsed">
                            <ul class="contact-infos">

                                @forelse($locations as $location)
                                    <li>
                                        <div class="icon_box"><i class="fa fa-map-marker"></i></div>
                                        <div class="text-box">
                                            <p><strong>{{ $location->title }}</strong><br>{!! nl2br(e($location->address)) !!}</p>
                                        </div>
                                    </li>
                                @empty
                                    @if(!empty($setting->business_address))
                                        <li>
                                            <div class="icon_box"><i class="fa fa-map-marker"></i></div>
                                            <div class="text-box">
                                                <p><strong>Address:</strong><br>{!! nl2br(e($setting->business_address)) !!}</p>
                                            </div>
                                        </li>
                                    @endif
                                @endforelse

                                @if($email)
                                    <li>
                                        <div class="icon_box"><i class="fa-solid fa-envelope"></i></div>
                                        <div class="text-box">
                                            <p><strong>Email:-</strong><br><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                                        </div>
                                    </li>
                                @endif

                                @if($phones->isNotEmpty())
                                    <li>
                                        <div class="icon_box"><i class="fa-solid fa-phone"></i></div>
                                        <div class="text-box">
                                            <p>
                                                <strong>Phone:-</strong><br>
                                                @foreach($phones as $phone)
                                                    <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a>@if(!$loop->last), @endif
                                                @endforeach
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                @if(!empty($setting->whatsapp))
                                    <li>
                                        <div class="icon_box"><i class="fa-brands fa-whatsapp"></i></div>
                                        <div class="text-box">
                                            <p>
                                                <strong>WhatsApp:-</strong><br>
                                                <a href="https://wa.me/{{ preg_replace('/\D/', '', $setting->whatsapp) }}" target="_blank" rel="noopener">{{ $setting->whatsapp }}</a>
                                            </p>
                                        </div>
                                    </li>
                                @endif

                                @if(!empty($setting->business_hours))
                                    <li>
                                        <div class="icon_box"><i class="fa-regular fa-clock"></i></div>
                                        <div class="text-box">
                                            <p><strong>Business Hours:-</strong><br>{!! nl2br(e($setting->business_hours)) !!}</p>
                                        </div>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Column -->
            <div class="column form-column col-xxl-7 col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
                <div class="box-form">
                    <div class="section-title">
                        <h3>Send Message</h3>
                        <span class="decor"></span>
                    </div>

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

                            <form id="contact_form" name="contact_form" class="home-contact-form contact-form select-form" action="{{ route('enquiry.submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="form_type" value="contact">

                                <div class="row clearfix">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" name="form_name" class="form-control" value="{{ old('form_name') }}" placeholder="Your Name *" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="email" name="form_email" class="form-control required email" value="{{ old('form_email') }}" placeholder="Your Mail *" required>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" name="form_phone" value="{{ old('form_phone') }}" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" name="form_subject" value="{{ old('form_subject') }}" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <textarea name="form_message" class="form-control textarea required" placeholder="Your Message....">{{ old('form_message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <input id="form_botcheck" name="form_botcheck" class="form-control" type="hidden" value="">
                                            <button class="thm-btn thm-color" type="submit" data-loading-text="Please wait...">send message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(!empty($setting->google_map_url))
    <section class="home-google-map">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <iframe src="{{ $setting->google_map_url }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
@endif

@endsection