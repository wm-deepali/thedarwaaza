@extends('layouts.app')

@section('title', 'About | The Darwaaza')
@section('meta_description', 'About | The Darwaaza')
@section('meta_keywords', 'About | The Darwaaza')
@section('canonical', 'https://thedarwaaza.com/about')

@section('content')

<div class="inner-banner has-base-color-overlay text-center" style="background: url({{ asset('assets/images/background/inner-page-banner.jpg') }}); background-repeat: no-repeat; background-size: cover;">
    <div class="container">
        <div class="box">
            <h3>About Us</h3>
        </div>
    </div>
    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="pull-left">
                <ul class="list-inline link-list">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ url('about.') }}">About Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="two-column">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-12">
                <div class="img-box">
                    <img src="{{ asset('assets/images/about.jpg') }}" alt="About The Darwaaza">
                </div>
            </div>
            <div class="col-md-7 col-sm-12">
                <div class="section-title">
                    <h2>About Us</h2>
                    <span class="decor"></span>
                </div>
                <div class="text">
                    <p>Company profile with all the details to be covered We're a Lucknow (Uttar Pradesh) based industry with two manufacturing units. We have already set our standards high from other retailers in the industry due to the strong commitment to the service we provide, we are one of the few retailers who are on top of their business, standing out from the others. We are still growing in this industry and want to become one of the largest retailers in the designer doors industry. We are known for providing high levels of personalized services to our clients.</p>
                    <p>We are a team of qualified staff who master the art of carpentry, and we can assist and advice you in choosing the suitable product for your home and other commercial building. We rest assure you that your products will perfectly fit your space and the doors we provide will make you go awestruck. Moreover, free measurement and quote services we offer makes us different from other retailers.</p>
                    <p>On the other, we provide free delivery services and make sure that the product to deliver at your doorstep safely. Moreover, you don’t have to worry about the installation of the doors; our expert carpenters will come to your house and install your doors professionally. We design and manufacture some of the authentic looking designer doors for indoor as well as outdoor. Also, with the likes of smart doors, we are the one giving competition to every other retailer in the market.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="why-choos" class="bg-color">
    <div class="container">
        <h2>Why Choose Us</h2>
        <p>Due to our strong commitment to the services we offer, we have already raised the bar for other retailers in the sector. We are one of the few retailers who are on top of their game and stand out from the competition.</p>
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

<section id="brochure">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" style="padding: 0px">
                <img src="{{ asset('assets/images/brochure.jpg') }}" alt="Brochure">
            </div>
            <div class="col-md-6 brochure-text">
                <h2>LOOKING FOR <br>A UNIQUE DOOR? </h2>
                <p>You will love our wide range of products from Saina Doors.</p>
                <a href="{{ asset('pdf/brouchure.pdf') }}" target="_blank">Download Brochure</a>
            </div>
        </div>
    </div>
</section>

<section class="four-column">
    <div class="container text-center">
        <div class="section-title text-center">
            <h2>Working process</h2>
            <span class="decor"></span>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="single-item">
                    <div class="inner-box">
                        <div class="icon"><i class="flaticon-people"></i></div>
                    </div>
                    <h5>Meet Customers</h5>
                    <p>Our designers will meet the customer <br>and share about our ideas.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="single-item">
                    <div class="inner-box">
                        <div class="icon"><i class="rot flaticon-technology"></i></div>
                    </div>
                    <h5>Discuss Concept</h5>
                    <p>After customer meeting, our designer will give some idea to new design.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="single-item">
                    <div class="inner-box">
                        <div class="icon"><i class="rot icon-check"></i></div>
                    </div>
                    <h5>Confirm Agreement</h5>
                    <p>With 100% customer satifsfaction our designer confirn the agree.</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 text-center">
                <div class="single-item">
                    <div class="inner-box">
                        <div class="icon"><i class="rot flaticon-drawing"></i></div>
                    </div>
                    <h5>Design & Install</h5>
                    <p>After the confirmation our designing team will design & Completed.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection