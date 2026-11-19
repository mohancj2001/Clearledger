@extends('layouts.app')
@section('title', 'Create your account')
@section('content')
<section class="auth-section">
    <div class="auth-card">
        <div class="eyebrow">LET’S GET STARTED</div>
        <h1>Your clearer<br><em>chapter begins.</em></h1>
        <p>Create an account to book time with our team.</p>
        <form method="POST" action="{{ route('register.store') }}">@csrf<div class="mb-3"><label class="form-label" for="name">Your name</label><input class="form-control" id="name" name="name" value="{{ old('name') }}" required autocomplete="name"></div>
            <div class="mb-3"><label class="form-label" for="email">Email address</label><input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"></div>
            <div class="mb-3"><label class="form-label" for="phone">Phone number <span class="optional">(optional)</span></label><input class="form-control" id="phone" name="phone" value="{{ old('phone') }}" autocomplete="tel"></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label" for="password">Password</label><input class="form-control" id="password" name="password" type="password" required autocomplete="new-password"></div>
                <div class="col-md-6 mb-3"><label class="form-label" for="password_confirmation">Confirm password</label><input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"></div>
            </div><button class="btn btn-forest btn-lg rounded-pill w-100 mt-2" type="submit">Create my account <span class="ms-2">↗</span></button>
        </form>
        <div class="auth-switch">Already have an account? <a href="{{ route('login') }}">Log in</a></div>
    </div>
    <div class="auth-side">
        <div class="auth-side-art"><span>✳</span></div>
        <p>“I left with a plan, not a pile of paperwork and more questions.”</p><small>A CLEARLEDGER CLIENT</small>
    </div>
</section>
@endsection