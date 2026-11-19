@extends('layouts.app')
@section('title', 'Log in')
@section('content')
<section class="auth-section">
    <div class="auth-card">
        <div class="eyebrow">WELCOME BACK</div>
        <h1>Good to see<br><em>you again.</em></h1>
        <p>Log in to check in on your tax journey.</p>
        <form method="POST" action="{{ route('login.store') }}">@csrf<div class="mb-3"><label class="form-label" for="email">Email address</label><input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email"></div>
            <div class="mb-3"><label class="form-label" for="password">Password</label><input class="form-control" id="password" name="password" type="password" required autocomplete="current-password"></div><label class="remember-row"><input type="checkbox" name="remember"> Keep me logged in</label><button class="btn btn-forest btn-lg rounded-pill w-100 mt-3" type="submit">Log in <span class="ms-2">↗</span></button>
        </form>
        <div class="auth-switch">New to ClearLedger? <a href="{{ route('register') }}">Create an account</a></div>
    </div>
    <div class="auth-side">
        <div class="auth-side-art"><span>✳</span></div>
        <p>“Finally, tax help that feels like someone’s actually in my corner.”</p><small>A CLEARLEDGER CLIENT</small>
    </div>
</section>
@endsection