@extends('layouts.app')
@section('title', 'Tax clarity, made personal')
@section('content')
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <div class="eyebrow"><span class="eyebrow-dot"></span> YOUR TAX PARTNER, NOT JUST A PREPARER</div>
            <h1>Tax season,<br><em>minus the</em> stress.</h1>
            <p class="hero-lead">Good tax advice should feel clear, considered, and completely personal. We make the complicated feel simple — all year long.</p>
            <div class="hero-actions"><a class="btn btn-forest btn-lg rounded-pill px-4" href="{{ route('appointments.create') }}">Book a consultation <span class="ms-2">↗</span></a><a class="text-link" href="{{ route('services.index') }}">Explore our services <span>→</span></a></div>
            <div class="hero-proof"><div class="avatar-stack"><span>J</span><span>M</span><span>A</span><span>+</span></div><div><strong>Good people. Clear answers.</strong><small>Personal tax support that feels different.</small></div></div>
        </div>
        <div class="hero-visual">
            <div class="hero-photo"><img class="hero-illustration" src="{{ asset('images/hero-illustration.svg') }}" alt="A calm, organized workspace for thoughtful tax planning"><div class="photo-caption"><span class="caption-icon">✳</span><span>Clarity, at every step.</span></div></div>
            <div class="floating-note"><span class="note-icon">↗</span><div><strong>More than tax returns</strong><small>Here for the bigger picture.</small></div></div>
            <div class="hero-stamp"><span>PEACE OF</span><strong>MIND</strong><span>STARTS HERE</span><i>✳</i></div>
        </div>
    </div>
    <div class="container hero-foot"><span>PERSONAL TAX</span><span>SMALL BUSINESS</span><span>YEAR-ROUND ADVICE</span><span class="scroll-hint">SCROLL TO EXPLORE <b>↓</b></span></div>
</section>
<section class="trust-strip"><div class="container trust-inner"><span>THE CLEARER WAY TO DO TAX</span><span>Thoughtful advice <b>✳</b></span><span>People-first service <b>✳</b></span><span>No-surprise pricing <b>✳</b></span><span>Support all year <b>✳</b></span></div></section>
<section class="section-pad services-home" id="services">
    <div class="container">
        <div class="section-heading"><div><div class="eyebrow">HOW WE CAN HELP</div><h2>Tax support that<br><em>fits your life.</em></h2></div><p>Whether you’re filing your first return or planning what comes next, you’ll find a clear path forward here.</p></div>
        <div class="service-grid">
            @foreach ($services as $index => $service)
                <a class="service-card" href="{{ route('services.show', $service) }}">
                    <div class="service-card-top"><span class="service-number">0{{ $index + 1 }}</span><span class="service-arrow" aria-hidden="true">↗</span></div>
                    <div class="service-symbol" aria-hidden="true">
                        @switch($index % 5)
                            @case(0)
                                <svg viewBox="0 0 24 24" fill="none"><path d="M5 4.5h9.5L19 9v10.5H5V4.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M14 4.5V9h5M8 13h8M8 16.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                @break
                            @case(1)
                                <svg viewBox="0 0 24 24" fill="none"><path d="M4.5 18.5V7.25a2.25 2.25 0 0 1 2.25-2.25H19.5v13.5H6.75a2.25 2.25 0 0 0-2.25 2.25Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M4.5 18.5a2.25 2.25 0 0 0 2.25 2.25H19.5M8.5 9h7M8.5 12.5h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                @break
                            @case(2)
                                <svg viewBox="0 0 24 24" fill="none"><path d="M5 18.5 18.5 5M10 5h8.5v8.5M6 19h12" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @break
                            @case(3)
                                <svg viewBox="0 0 24 24" fill="none"><path d="M12 4.5v15M4.5 12h15M6.7 6.7l10.6 10.6M17.3 6.7 6.7 17.3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                                @break
                            @default
                                <svg viewBox="0 0 24 24" fill="none"><path d="M5 5h14v14H5zM8.5 8.5h7v7h-7zM8.5 5v3.5M15.5 5v3.5M8.5 15.5V19M15.5 15.5V19M5 8.5h3.5M15.5 8.5H19M5 15.5h3.5M15.5 15.5H19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        @endswitch
                    </div>
                    <span class="service-category">{{ $service->category }}</span>
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->summary }}</p>
                    <span class="card-bottom">Explore service <span aria-hidden="true">→</span></span>
                </a>
            @endforeach
        </div>
        <div class="center-link"><a class="text-link" href="{{ route('services.index') }}">See all tax services <span>→</span></a></div>
    </div>
</section>
<section class="about-section section-pad" id="about"><div class="container about-grid"><div class="about-image"><img src="{{ asset('images/about-illustration.svg') }}" alt="A tidy desk with a financial plan, checklist, and calculator"><div class="about-sticker">A HUMAN<br>APPROACH TO<br><em>YOUR TAXES</em></div></div><div class="about-copy"><div class="eyebrow">A DIFFERENT KIND OF TAX PARTNER</div><h2>We believe tax<br>advice should feel<br><em>like a weight off.</em></h2><p>We started ClearLedger to make tax support a little more human. No jargon, no judgment — just thoughtful expertise from people who take the time to understand what matters to you.</p><p>From your first question to your next big decision, we’re in your corner.</p><a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('services.index') }}">Get to know our services <span class="ms-2">↗</span></a></div></div></section>
<section class="cta-band"><div class="container cta-inner"><div><div class="eyebrow">A GOOD PLACE TO START</div><h2>Let’s make your next<br>tax decision <em>clearer.</em></h2></div><a class="btn btn-cream rounded-pill px-4 py-3" href="{{ route('appointments.create') }}">Find a time to talk <span class="ms-3">↗</span></a><span class="cta-spark">✳</span></div></section>
@endsection
