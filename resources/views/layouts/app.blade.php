<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ClearLedger Tax') · ClearLedger</title>
    <meta name="description" content="@yield('meta', 'Thoughtful tax advice for individuals and small businesses.')">
    <link rel="icon" type="image/png" href="{{ asset('images/leaf.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern.css') }}" rel="stylesheet">
</head>
<body>
<div class="topline"><div class="container topline-inner"><span>Thoughtful tax support, all year round</span><a href="mailto:hello@clearledger.tax">hello@clearledger.tax <span aria-hidden="true">↗</span></a></div></div>
<header class="site-header">
    <nav class="navbar navbar-expand-lg container py-3" aria-label="Main navigation">
        <a class="brand" href="{{ route('home') }}" aria-label="ClearLedger home">
            <span class="brand-mark"><svg viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M7 6.5h11.5L25 13v12.5H7V6.5Z" stroke="currentColor" stroke-width="2"/><path d="M18 7v7h7M11 18h10M11 22h7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span>
            <span class="brand-name">clearledger<span>.</span><small>TAX & ADVISORY</small></span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto gap-lg-4">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('services.index') }}">Our services</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#about">About us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#contact">Contact</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    <a class="nav-link nav-dashboard" href="{{ auth()->user()->isAdmin() ? route('admin.index') : route('dashboard') }}">{{ auth()->user()->isAdmin() ? 'Admin' : 'My account' }}</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-outline-dark btn-sm rounded-pill px-3" type="submit">Log out</button></form>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Log in</a>
                    <a class="btn btn-forest rounded-pill px-4" href="{{ route('register') }}">Get started <span aria-hidden="true">↗</span></a>
                @endauth
            </div>
        </div>
    </nav>
</header>
<main>
    @if (session('success') || $errors->any())
        <div class="container flash-wrap">
            @if (session('success'))<div class="alert alert-success alert-dismissible fade show" role="status">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>@endif
            @if ($errors->any())<div class="alert alert-danger" role="alert"><strong>Please check the form and try again.</strong><ul class="mb-0 mt-2">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
        </div>
    @endif
    @yield('content')
</main>
<footer class="site-footer" id="contact">
    <div class="container footer-grid">
        <div><a class="brand footer-brand" href="{{ route('home') }}"><span class="brand-mark"><svg viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M7 6.5h11.5L25 13v12.5H7V6.5Z" stroke="currentColor" stroke-width="2"/><path d="M18 7v7h7M11 18h10M11 22h7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></span><span class="brand-name">clearledger<span>.</span><small>TAX & ADVISORY</small></span></a><p class="footer-copy">A little more clarity.<br>A lot more confidence.</p></div>
        <div><h3>Explore</h3><a href="{{ route('services.index') }}">Tax services</a><a href="{{ route('appointments.create') }}">Book a consultation</a><a href="{{ route('register') }}">Create an account</a></div>
        <div><h3>Get in touch</h3><a href="mailto:hello@clearledger.tax">hello@clearledger.tax</a><a href="tel:+15550142026">+1 (555) 014-2026</a><span>Mon–Fri, 9am–5pm</span></div>
        <div class="footer-note">Your next step,<br><em>made clearer.</em><a href="{{ route('appointments.create') }}" aria-label="Book an appointment">↗</a></div>
    </div>
    <div class="container footer-bottom"><span>© {{ date('Y') }} ClearLedger Tax & Advisory</span><span>Clear advice. No surprises.</span></div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
