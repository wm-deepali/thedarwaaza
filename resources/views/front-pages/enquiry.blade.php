@extends('layouts.app')

@php
    // controller se na aaye to bhi error na de
    $product = $product ?? null;
    $siteName = $general->site_name ?: 'The Darwaaza';
@endphp

@section('title', 'Enquiry | ' . $siteName)
@section('canonical', url('/enquiry'))

@section('content')

<div class="inner-banner has-base-color-overlay text-center" style="background: url({{ asset('assets/images/background/inner-page.jpg') }});">
    <div class="container">
        <div class="box">
            <h3>Enquiry Now</h3>
        </div>
    </div>
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="pull-left">
                <ul class="list-inline link-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('enquiry') }}">Enquiry Now</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="single_contact_form">
    <div class="container">
        <div class="row">
            <!-- Form Column -->
            <div class="column form-column col-md-6 col-sm-12 col-xs-12">
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

                            @if($product)
                                <p><strong>Enquiring about:</strong> {{ $product->name ?: 'Selected product' }}</p>
                            @endif

                            <form id="contact_form" name="contact_form" class="home-contact-form contact-form select-form" action="{{ route('enquiry.submit') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ old('product_id', $product?->id) }}">

                                <div class="row clearfix">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" name="form_name" class="form-control" value="{{ old('form_name') }}" placeholder="Your Name *" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="email" name="form_email" class="form-control required email" value="{{ old('form_email') }}" placeholder="Your Mail *" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" name="form_phone" value="{{ old('form_phone') }}" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <input type="text" name="form_subject" value="{{ old('form_subject', $product?->name) }}" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <textarea name="form_message" class="form-control textarea required" placeholder="Your Message....">{{ old('form_message') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
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

            @if(filled($general->google_map_url))
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <iframe src="{{ $general->google_map_url }}" width="100%" height="510" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection