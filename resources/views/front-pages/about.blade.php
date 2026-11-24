@extends('layouts.app')

@section('content')

<div class="inner-banner has-base-color-overlay text-center" style="background: url({{ asset('assets/images/background/inner-page-banner.jpg') }}); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="box">
            <h3>{{ $page->banner_title ?: 'About Us' }}</h3>
        </div>
    </div>
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="pull-left">
                <ul class="list-inline link-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">{{ $page->banner_title ?: 'About Us' }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="two-column">
    <div class="container">
        <div class="row">
            @if($page->about_image_url)
                <div class="col-md-5 col-sm-12">
                    <div class="img-box">
                        <img src="{{ $page->about_image_url }}" alt="{{ $page->about_heading }}">
                    </div>
                </div>
            @endif
            <div class="{{ $page->about_image_url ? 'col-md-7' : 'col-md-12' }} col-sm-12">
                <div class="section-title">
                    <h2>{{ $page->about_heading }}</h2>
                    <span class="decor"></span>
                </div>
                <div class="text">
                    @foreach($page->paragraphs as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if($whyItems->isNotEmpty())
<section id="why-choos" class="bg-color">
    <div class="container">
        <h2>{{ $page->why_heading }}</h2>
        @if(filled($page->why_text))
            <p>{{ $page->why_text }}</p>
        @endif
        <div class="row">
            @foreach($whyItems as $item)
                <div class="col-md-4">
                    <div class="why-text">
                        @if($item->image_url)
                            <img src="{{ $item->image_url }}" alt="{{ $item->title }}">
                        @endif
                        <h3>{{ $item->title }}</h3>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if(filled($page->brochure_heading))
<section id="brochure">
    <div class="container-fluid">
        <div class="row">
            @if($page->brochure_image_url)
                <div class="col-md-6" style="padding: 0px">
                    <img src="{{ $page->brochure_image_url }}" alt="Brochure">
                </div>
            @endif
            <div class="col-md-6 brochure-text">
                <h2>{!! nl2br(e($page->brochure_heading)) !!}</h2>
                @if(filled($page->brochure_text))
                    <p>{{ $page->brochure_text }}</p>
                @endif
                <a href="{{ $page->brochure_link_url }}" target="_blank">Download Brochure</a>
            </div>
        </div>
    </div>
</section>
@endif

@if($processItems->isNotEmpty())
<section class="four-column">
    <div class="container text-center">
        <div class="section-title text-center">
            <h2>{{ $page->process_heading }}</h2>
            <span class="decor"></span>
        </div>
        <div class="row">
            @foreach($processItems as $item)
                <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                    <div class="single-item">
                        <div class="inner-box">
                            <div class="icon"><i class="{{ $item->icon }}"></i></div>
                        </div>
                        <h5>{{ $item->title }}</h5>
                        <p>{{ $item->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection