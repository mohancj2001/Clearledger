@extends('layouts.app')
@section('title', 'Our tax services')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="eyebrow">HERE FOR THE WHOLE PICTURE</div>
        <h1>Tax support for<br><em>real life.</em></h1>
        <p>Clear guidance for every chapter — from your first return to your next big business decision.</p>
    </div>
</section>
<section class="section-pad">
    <div class="container service-grid">
        @foreach ($services as $index => $service)
        <a class="service-card" href="{{ route('services.show', $service) }}">
            <div class="service-card-top"><span class="service-number">0{{ $index + 1 }}</span><span class="service-arrow">↗</span></div>
            <div class="service-symbol">{{ ['◌','⌁','↗','✳','▦'][$index % 5] }}</div><span class="service-category">{{ $service->category }}</span>
            <h3>{{ $service->name }}</h3>
            <p>{{ $service->summary }}</p><span class="price-note">Starting at LKR {{ number_format($service->price_from) }}</span><span class="card-bottom">Learn more <span>→</span></span>
        </a>
        @endforeach
    </div>
</section>
<section class="cta-band">
    <div class="container cta-inner">
        <div>
            <div class="eyebrow">NOT SURE WHERE TO START?</div>
            <h2>We’ll help you find<br>the <em>right next step.</em></h2>
        </div><a class="btn btn-cream rounded-pill px-4 py-3" href="{{ route('appointments.create') }}">Book a consultation <span class="ms-3">↗</span></a>
    </div>
</section>
@endsection