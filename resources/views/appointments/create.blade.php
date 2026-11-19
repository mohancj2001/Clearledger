@extends('layouts.app')
@section('title', 'Book an appointment')
@section('content')
<section class="page-hero">
    <div class="container">
        <div class="eyebrow">A GOOD PLACE TO START</div>
        <h1>Let’s find a time<br><em>to talk.</em></h1>
        <p>Tell us what you need and choose a time that works. Our team will confirm your appointment shortly.</p>
    </div>
</section>
<section class="section-pad">
    <div class="container booking-wrap">
        <form class="form-card" method="POST" action="{{ route('appointments.store') }}">@csrf<h2>Your appointment</h2>
            <p class="form-intro">All fields marked with * are required.</p>
            <div class="mb-4"><label class="form-label" for="tax_service_id">What can we help with? *</label><select class="form-select" id="tax_service_id" name="tax_service_id" required>
                    <option value="">Select a service</option>@foreach ($services as $service)<option value="{{ $service->id }}" @selected(old('tax_service_id', $selectedService)==$service->id)>{{ $service->name }} · from LKR {{ number_format($service->price_from) }}</option>@endforeach
                </select></div>
            <div class="mb-4"><label class="form-label" for="scheduled_at">Preferred date and time *</label><input class="form-control" id="scheduled_at" name="scheduled_at" type="datetime-local" value="{{ old('scheduled_at') }}" min="{{ now()->addHour()->format('Y-m-d\TH:i') }}" required></div>
            <div class="mb-4"><label class="form-label" for="notes">Anything you’d like us to know? <span class="optional">(optional)</span></label><textarea class="form-control" id="notes" name="notes" rows="4" maxlength="2000" placeholder="A little context helps us make the most of our time together.">{{ old('notes') }}</textarea></div>
            <div class="privacy-note"><span>✳</span>
                <p>Your information stays private and is only shared with the tax professional helping you.</p>
            </div><button class="btn btn-forest btn-lg rounded-pill px-4 mt-4" type="submit">Request appointment <span class="ms-2">↗</span></button>
        </form>
        <aside class="booking-aside">
            <div class="service-symbol">◌</div>
            <div class="eyebrow">WHAT HAPPENS NEXT</div>
            <h3>A real person<br>will be in touch.</h3>
            <p>We’ll review your request and follow up to confirm the details. You can check the status any time from your dashboard.</p>
            <div class="step-item"><span>01</span>
                <div><strong>Pick your service</strong><small>Choose the support that fits.</small></div>
            </div>
            <div class="step-item"><span>02</span>
                <div><strong>Choose a time</strong><small>Tell us when works for you.</small></div>
            </div>
            <div class="step-item"><span>03</span>
                <div><strong>We’ll take it from here</strong><small>Our team will confirm with you.</small></div>
            </div>
        </aside>
    </div>
</section>
@endsection