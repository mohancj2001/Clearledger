@extends('layouts.app')
@section('title', $service->name)
@section('content')
<section class="page-hero">
    <div class="container"><a class="back-link" href="{{ route('services.index') }}">← All services</a>
        <div class="eyebrow mt-4">{{ $service->category }}</div>
        <h1>{{ $service->name }}<br><em>made clearer.</em></h1>
        <p>{{ $service->summary }}</p>
    </div>
</section>
<section class="section-pad">
    <div class="container detail-grid">
        <div class="detail-copy">
            <div class="eyebrow">WHAT TO EXPECT</div>
            <h2>Expert advice,<br><em>without the jargon.</em></h2>
            <p>{{ $service->description }}</p>
            <p>We’ll start by understanding your situation, walk through your options, and make sure you leave knowing exactly what comes next.</p><a class="btn btn-forest rounded-pill px-4 py-3 mt-3" href="{{ route('appointments.create', ['service' => $service->id]) }}">Book this service <span class="ms-2">↗</span></a>
        </div>
        <aside class="detail-aside"><span class="service-symbol">✳</span>
            <h3>A clear next step.</h3>
            <p>One conversation can make all the difference. Choose a time that works for you and we’ll take it from there.</p>
            <div class="detail-meta"><span>Starting at</span><strong>LKR {{ number_format($service->price_from) }}</strong></div>
            <div class="detail-meta"><span>Typical session</span><strong>{{ $service->duration_minutes }} minutes</strong></div><a class="text-link" href="{{ route('appointments.create', ['service' => $service->id]) }}">Find a time <span>→</span></a>
        </aside>
    </div>
</section>
@endsection