@extends('layouts.app')

@section('title', $category->meta_title ?: $category->name . ' | The Darwaaza')
@section('meta_description', $category->meta_description)
@section('meta_keywords', $category->meta_keywords)
@section('canonical', $category->canonical_url ?: url($category->slug))

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
                            <li><a href="{{ url($ancestor->slug) }}">{{ $ancestor->name }}</a></li>
                        @endforeach
                        <li><a href="{{ url($category->slug) }}">{{ $category->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="our-services style-2">
        <div class="container">
            @forelse($category->activeChildren->chunk(4) as $chunk)
                <div class="row">
                    @if($chunk->count() < 4)
                        <div class="cent-col">
                    @endif

                        @foreach($chunk as $child)
                            <div class="col-md-3 col-sm-6">
                                <div class="single-our-service">
                                    <figure class="img-box">
                                        <a href="{{ url($child->slug) }}">
                                            <img src="{{ $child->image_url }}" alt="{{ $child->name }}">
                                        </a>
                                    </figure>
                                    <div class="text-box">
                                        <a href="{{ url($child->slug) }}">
                                            <h4>{{ $child->name }}</h4>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if($chunk->count() < 4)
                            </div>
                        @endif
                </div>
            @empty
                <div class="row">
                    <div class="col-md-12 text-center">
                        <p>No products found in this category.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

@endsection