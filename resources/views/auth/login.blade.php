@extends('layouts.admin-app')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato:400,700|Raleway:400,600,700');

        /* =====================================================
               LOGIN THEME VARIABLES (matched with site master stylesheet)
               Change colours only from here.
               ===================================================== */
        :root {
            --aw-primary: #b01d2d;
            /* site red - buttons, accents */
            --aw-primary-dark: #8a1623;
            /* darker red for gradient */
            --aw-accent: #f4cd32;
            /* site yellow - input focus */
            --aw-bg: #f2f2f2;
            /* site light grey section bg */
            --aw-black: #000000;
            --aw-text: #272727;
            --aw-white: #ffffff;
            --aw-line: #c5c5c5;
            /* site divider/border grey */
        }

        body {
            background: var(--aw-bg);
            font-family: 'Lato', sans-serif;
        }

        .login-wrapper {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 950px;
            display: flex;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
            background: var(--aw-white);
        }

        .logo-box {
            background: var(--aw-white);
            padding: 15px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .logo-box img {
            width: 140px;
            height: auto;
            max-height: 90px;
            object-fit: contain;
        }

        .login-left {
            position: relative;
            width: 45%;
            background: linear-gradient(135deg, var(--aw-primary), var(--aw-primary-dark));
            color: var(--aw-white);
            text-align: center;
            padding: 40px 20px;
        }

        /* thin inset border */
        .login-left::after {
            content: "";
            position: absolute;
            inset: 16px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            pointer-events: none;
        }

        .login-left img {
            width: 120px;
            margin-bottom: 20px;
        }

        .login-left h2 {
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-left p {
            font-size: 14px;
            color: var(--aw-white);
            opacity: 0.9;
        }

        .login-right {
            width: 55%;
            padding: 40px;
        }

        .login-title {
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--aw-black);
            position: relative;
            padding-bottom: 12px;
        }

        /* site style red underline under headings */
        .login-title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 14%;
            min-width: 50px;
            height: 2px;
            background: var(--aw-primary);
        }

        .login-right label {
            color: var(--aw-text);
            font-weight: 600;
            margin-bottom: 4px;
        }

        .form-control {
            border-radius: 4px;
            padding: 12px;
            background: var(--aw-white);
            border: 1px solid var(--aw-line);
            color: var(--aw-text);
        }

        .form-control:focus {
            box-shadow: none;
            border: 1px solid var(--aw-accent);
            background: var(--aw-white);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border-radius: 4px;
            border: 2px solid var(--aw-primary);
            background: var(--aw-primary);
            color: var(--aw-white);
            font-family: 'Raleway', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: var(--aw-black);
            border-color: var(--aw-black);
            color: var(--aw-white);
        }

        .form-check-label {
            font-size: 14px;
            font-weight: 400;
        }

        .form-check-input:checked {
            background-color: var(--aw-primary);
            border-color: var(--aw-primary);
        }

        .form-check-input:focus {
            box-shadow: none;
            border-color: var(--aw-accent);
        }

        .forgot-link {
            font-size: 14px;
            text-decoration: none;
            color: var(--aw-primary);
            font-weight: 600;
        }

        .forgot-link:hover {
            color: var(--aw-black);
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }

            .login-left,
            .login-right {
                width: 100%;
            }

            .login-left {
                background: linear-gradient(135deg, var(--aw-black), var(--aw-black));
            }
        }
    </style>

    @php
        $loginLogo = $general?->admin_login_logo;
        $siteName = $general?->site_name ?? 'The Darwaaza';
        $tagline = $general?->tagline ?? '';
    @endphp

    <div class="login-wrapper">
        <div class="login-card">

            <!-- LEFT SIDE -->
            <div class="login-left">

                <div class="logo-box">
                    @if($loginLogo)
                        <img src="{{ asset('storage/' . $loginLogo) }}" alt="{{ $siteName }}">
                    @else

                    @endif
                    <img src="{{ asset('assets/images/logo/logo.png') }}" alt="{{ $siteName }}">
                </div>

                <h2>{{ $siteName }}</h2>
                <p>{{ $tagline }}</p>
            </div>

            <!-- RIGHT SIDE -->
            <div class="login-right">
                <h4 class="login-title">Admin Login</h4>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>

                        @error('email')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label>Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required>

                        @error('password')
                            <span class="invalid-feedback d-block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- REMEMBER -->
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="btn btn-login">
                        Login
                    </button>

                </form>
            </div>

        </div>
    </div>

@endsection