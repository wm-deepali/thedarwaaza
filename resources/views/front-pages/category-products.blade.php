@extends('layouts.app')

@php
    // WhatsApp number from general settings: digits only, 10 digits gets the India code
    $waDigits = preg_replace('/\D/', '', (string) $general->whatsapp);
    if (strlen($waDigits) === 10) {
        $waDigits = '91' . $waDigits;
    }
    $hasWhatsapp = strlen($waDigits) >= 10;
@endphp

@push('styles')
<style>
    .overlay-one .enq-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .overlay-one .enq-btn-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 180px;
        padding: 10px 18px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.2;
        color: #fff !important;
        text-decoration: none !important;
        position: relative;
        z-index: 5;
        transition: opacity .2s;
    }

    .overlay-one .enq-btn-link:hover {
        opacity: .88;
    }

    .overlay-one .enq-btn-link.enq-main {
        background: #303d89;
    }

    .overlay-one .enq-btn-link.enq-wa {
        background: #25d366;
    }
</style>
@endpush

@section('content')

<div class="inner-banner has-base-color-overlay text-center"
     style="background: url({{ $category->banner_url ?: asset('assets/images/background/inner-page-banner.jpg') }}); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="box">
            <h3>{{ $category->name }}</h3>
        </div>
    </div>
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="pull-left">
                <ul class="list-inline link-list">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    @foreach($category->ancestors() as $ancestor)
                        <li><a href="{{ route('category.show', $ancestor->slug) }}">{{ $ancestor->name }}</a></li>
                    @endforeach
                    <li><a href="{{ route('category.show', $category->slug) }}">{{ $category->name }}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="project-content project_gallery">
    <div class="container">
        <div class="mixit-gallery" id="MixItUp74D189">
            <div class="row">
                @forelse($products as $product)
                    @php
                        $productName = $product->name ?: $category->name;

                        $waText = "Hi, I am interested in this product.\n"
                            . "Product: {$productName}\n"
                            . "Category: {$category->name}"
                            . ($product->image_url ? "\nImage: {$product->image_url}" : '');

                        $waLink = 'https://api.whatsapp.com/send?phone=' . $waDigits . '&text=' . rawurlencode($waText);
                    @endphp

                    <div class="col-md-3 mix col-sm-6 agricultural" style="display: inline-block;">
                        <article class="item">
                            <div class="inner-box">
                                @if($product->image_url)
                                    <figure class="image-box">
                                        <img src="{{ $product->image_url }}" alt="{{ $productName }}" loading="lazy" />
                                    </figure>
                                @endif

                                <!-- Overlay Box -->
                                <div class="overlay-one">
                                    <div class="overlay-inner">
                                        <div class="content">
                                            <div class="enq-actions">
                                                <a href="{{ route('enquiry', ['product' => $product->id]) }}"
                                                   class="enq-btn-link enq-main">
                                                    <i class="fa fa-envelope"></i> Enquiry Now
                                                </a>

                                                @if($hasWhatsapp)
                                                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                                       class="enq-btn-link enq-wa">
                                                        <i class="fa-brands fa-whatsapp"></i> Chat on WhatsApp
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-md-12 text-center">
                        <p>Products coming soon.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

@endsection