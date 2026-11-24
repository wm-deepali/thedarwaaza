<!-- fixed-top-->

<div class="row d-none">
    <div class="col-10">

        @if(session('success'))
            <div class="alert alert-info alert-dismissible fade in">
                <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                <strong>Success!</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade in">
                <a href="javascript:void(0);" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong> {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>

<!-- fixed-top-->

@php
    // admin-setting page is shared by General / SMTP / Tracking tabs
    $settingTab = request('tab', 'general');

    $marketingActive = request()->routeIs('admin.seo.*', 'admin.redirect-settings.*');
    $settingsActive = request()->routeIs('admin.settings.*', 'admin.security.*')
        || (request()->routeIs('admin.admin-setting.*'));
@endphp

<div id='cssmenu'>
    <ul class="pt-0">

        {{-- DASHBOARD --}}
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
        </li>

        {{-- CATALOG --}}
        <li class="{{ request()->routeIs('admin.categories.*', 'admin.products.*') ? 'active' : '' }}">
            <a href="#"><i class="fa-solid fa-boxes-stacked"></i> Catalog</a>
            <ul>
                <li><a href="{{ route('admin.categories.index') }}">Categories & Sub Categories</a></li>
                <li><a href="{{ route('admin.products.index') }}">Manage Products</a></li>
            </ul>
        </li>

        {{-- ENQUIRIES --}}
        <li class="{{ request()->routeIs('admin.contact-enquiries.*') ? 'active' : '' }}">
            <a href="#"><i class="fa-solid fa-envelope"></i> Enquiries</a>
            <ul>
                <li><a href="{{ route('admin.contact-enquiries.index') }}">Enquiries</a></li>
            </ul>
        </li>

        {{-- WEBSITE CONTENT --}}
        <li
            class="{{ request()->routeIs('admin.home-blocks.*', 'admin.about-page.*', 'admin.contact-locations.*') ? 'active' : '' }}">
            <a href="#"><i class="fa-solid fa-globe"></i> Website Content</a>
            <ul>
                <li><a href="{{ route('admin.home-blocks.index') }}">Home Page</a></li>
                <li><a href="{{ route('admin.about-page.edit') }}">About Page</a></li>
                <li><a href="{{ route('admin.contact-locations.index') }}">Contact Addresses</a></li>
            </ul>
        </li>

        {{-- SEO & MARKETING --}}
        <li class="{{ $marketingActive ? 'active' : '' }}">
            <a href="#"><i class="fa-solid fa-bullhorn"></i> SEO & Marketing</a>
            <ul>
                <li><a href="{{ route('admin.seo.index') }}">SEO Management</a></li>
                <li><a href="{{ route('admin.redirect-settings.index') }}">Re-Direction Setting</a></li>
            </ul>
        </li>

        {{-- SETTINGS --}}
        <li class="{{ $settingsActive ? 'active' : '' }}">
            <a href="#"><i class="fa-solid fa-gear"></i> Settings</a>
            <ul>
                <li><a href="{{ route('admin.admin-setting.index', ['tab' => 'general']) }}">General Setting</a></li>
                <li><a href="{{ route('admin.admin-setting.index', ['tab' => 'smtp']) }}">SMTP</a></li>
                <li><a href="{{ route('admin.settings.email-templates.index') }}">Email Template Settings</a></li>
                <li><a href="{{ route('admin.security.system-logs') }}">System Logs</a></li>
            </ul>
        </li>

    </ul>
</div>