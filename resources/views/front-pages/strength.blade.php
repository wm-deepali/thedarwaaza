@extends('layouts.app')

@section('title', 'Our Strength | The Darwaaza')
@section('meta_description', 'The Darwaaza is Leading Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow. Get Here door at best price')
@section('meta_keywords', 'Jali in Lucknow, MDF Jali in Lucknow, WPC Jali in Lucknow, Hardware Filling in Lucknow, Sun Board in Lucknow')
@section('canonical', 'https://thedarwaaza.com/strength')

@section('content')

<div class="inner-banner has-base-color-overlay text-center"
     style="background: url({{ asset('assets/images/background/strength.jpg') }}); background-repeat: no-repeat; background-size: cover; background-position: left center;">
    <div class="container">
        <div class="box">
            <h3>Our Strength</h3>
        </div>
    </div>
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="pull-left">
                <ul class="list-inline link-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('strength') }}">Our Strength</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="strength">
    <div class="container">
        <div class="text-center section-title">
            <h2>Our Strength</h2>
            <span class="decor"></span>
        </div>
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <img src="{{ asset('assets/images/strength.jpeg') }}" class="img-fluid strength-img" alt="Our Strength - The Darwaaza">
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <video width="100%" src="{{ asset('assets/images/strength-video.mp4') }}" class="strenth-video"
                       autoplay loop muted playsinline></video>
            </div>
        </div>
    </div>
</section>

@endsection