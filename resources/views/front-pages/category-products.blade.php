@extends('layouts.app')

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
                    <div class="col-md-3 mix col-sm-6 agricultural" style="display: inline-block;">
                        <article class="item">
                            <div class="inner-box">
                                @if($product->image_url)
                                    <figure class="image-box">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name ?: $category->name }}" loading="lazy" />
                                    </figure>
                                @endif
                                <!-- Overlay Box -->
                                <a href="{{ route('enquiry', ['product' => $product->id]) }}">
                                    <div class="overlay-one">
                                        <div class="overlay-inner">
                                            <div class="content">
                                                <h4>Enquiry Now</h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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