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

    <section class="our-services style-2">
        <div class="container">
            @foreach($category->activeChildren->chunk(4) as $chunk)
                <div class="row">
                    @if($chunk->count() < 4)
                        <div class="cent-col">
                    @endif

                        @foreach($chunk as $child)
                            <div class="col-md-3 col-sm-6">
                                <div class="single-our-service">
                                    @if($child->image_url)
                                        <figure class="img-box">
                                            <a href="{{ route('category.show', $child->slug) }}">
                                                <img src="{{ $child->image_url }}" alt="{{ $child->name }}">
                                            </a>
                                        </figure>
                                    @endif
                                    <div class="text-box">
                                        <a href="{{ route('category.show', $child->slug) }}">
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
            @endforeach
        </div>
    </section>

@endsection