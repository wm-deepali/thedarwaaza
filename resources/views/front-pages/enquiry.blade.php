@extends('layouts.app')

@section('title', 'Enquiry | The Darwaaza')
@section('canonical', 'https://thedarwaaza.com/enquiry')

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
                    <li><a href="{{ route('enquiry') }}">enquiry Now</a></li>
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
                            {{-- TODO: point this to your own route/controller (old action was a demo URL) --}}
                            <form id="contact_form" name="contact_form" class="home-contact-form contact-form select-form" action="#" method="POST">
                                @csrf
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
                                            <input type="text" name="form_subject" value="{{ old('form_subject') }}" placeholder="Subject">
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

            <div class="col-md-6 col-sm-6 col-xs-12">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.0614520483236!2d80.92167791504335!3d26.83799768315979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399bfdb44787aacb%3A0xb71b336be205a061!2sThe%20Hamam%20The%20Darwaaza!5e0!3m2!1sen!2sin!4v1677669256990!5m2!1sen!2sin" width="100%" height="510" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection