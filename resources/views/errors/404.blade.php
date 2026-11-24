@extends('layouts.app')

@push('styles')
<style>
    .not-found {
        padding: 80px 0 90px;
        text-align: center;
    }

    .not-found .nf-code {
        display: block;
        font-size: 130px;
        font-weight: 800;
        line-height: 1;
        color: #303d89;
        opacity: .12;
        margin-bottom: -40px;
    }

    .not-found h2 {
        font-size: 32px;
        font-weight: 700;
        margin: 0 0 14px;
        position: relative;
    }

    .not-found p {
        max-width: 520px;
        margin: 0 auto 28px;
        font-size: 16px;
        color: #666;
    }

    .not-found .nf-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .not-found .nf-btn {
        display: inline-block;
        padding: 12px 28px;
        border-radius: 3px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        text-decoration: none !important;
        transition: opacity .2s;
    }

    .not-found .nf-btn:hover {
        opacity: .88;
    }

    .not-found .nf-btn.nf-primary {
        background: #303d89;
        color: #fff !important;
    }

    .not-found .nf-btn.nf-outline {
        border: 2px solid #303d89;
        color: #303d89 !important;
    }

    @media (max-width: 767px) {
        .not-found { padding: 50px 0 60px; }
        .not-found .nf-code { font-size: 90px; margin-bottom: -26px; }
        .not-found h2 { font-size: 24px; }
    }
</style>
@endpush

@section('content')

    <div class="inner-banner has-base-color-overlay text-center"
        style="background: url({{ asset('assets/images/background/inner-page-banner.jpg') }}); background-repeat: no-repeat; background-size: cover;">
        <div class="container">
            <div class="box">
                <h3>Page Not Found</h3>
            </div>
        </div>
        <div class="breadcumb-wrapper">
            <div class="container">
                <div class="pull-left">
                    <ul class="list-inline link-list">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="javascript:void(0);">404</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <section class="not-found">
        <div class="container">
            <span class="nf-code" aria-hidden="true">404</span>
            <h2>Oops! This Page Has Gone Missing</h2>
            <p>The page you are looking for may have been moved, renamed or no longer exists.</p>

            <div class="nf-actions">
                <a href="{{ route('home') }}" class="nf-btn nf-primary">
                    <i class="fa fa-home"></i> Back to Home
                </a>
                <a href="{{ route('enquiry') }}" class="nf-btn nf-outline">Send Enquiry</a>
                <a href="{{ route('contact') }}" class="nf-btn nf-outline">Contact Us</a>
            </div>
        </div>
    </section>

@endsection