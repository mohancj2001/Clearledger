@extends('layouts.app')
@section('title', 'Your dashboard')
@section('content')
<section class="dashboard-head"><div class="container dashboard-head-inner"><div><div class="eyebrow">YOUR CLEARLEDGER SPACE</div><h1>Welcome back, <em>{{ Str::of(auth()->user()->name)->before(' ') }}.</em></h1><p>Here’s where things stand. We’re here if you need us.</p></div><a class="btn btn-forest rounded-pill px-4" href="{{ route('appointments.create') }}">Book a time <span class="ms-2">↗</span></a></div></section>
<section class="section-pad dashboard-section"><div class="container">
    <div class="dashboard-summary"><div><span class="summary-label">APPOINTMENTS</span><strong>{{ $appointments->count() }}</strong><small>on your calendar</small></div><div><span class="summary-label">SERVICE REQUESTS</span><strong>{{ $serviceRequests->count() }}</strong><small>being looked after</small></div><div><span class="summary-label">DOCUMENTS</span><strong>{{ $documents->count() }}</strong><small>securely stored</small></div><div class="summary-note"><span>✳</span><p>A question on your mind?<br><a href="mailto:hello@clearledger.tax">We’re just an email away.</a></p></div></div>
    <div class="dashboard-columns">
        <div class="dashboard-main">
            <section class="panel-card" id="appointments"><div class="panel-heading"><div><div class="eyebrow">YOUR NEXT STEPS</div><h2>Appointments</h2></div><a class="text-link" href="{{ route('appointments.create') }}">Book another <span>→</span></a></div>
                @forelse ($appointments as $appointment)
                    <div class="appointment-row"><div class="appointment-date"><strong>{{ $appointment->scheduled_at->format('d') }}</strong><span>{{ $appointment->scheduled_at->format('M') }}</span></div><div class="appointment-info"><strong>{{ $appointment->service->name }}</strong><span>{{ $appointment->scheduled_at->format('l, F j · g:i A') }}</span>@if ($appointment->notes)<small>{{ $appointment->notes }}</small>@endif</div><span class="status-pill status-{{ $appointment->status }}">{{ str_replace('_', ' ', $appointment->status) }}</span></div>
                @empty
                    <div class="empty-state"><span>◷</span><strong>Your next step starts here.</strong><p>No appointments yet. Choose a time to talk with our team.</p><a class="text-link" href="{{ route('appointments.create') }}">Book your first appointment <span>→</span></a></div>
                @endforelse
            </section>
            <section class="panel-card" id="requests"><div class="panel-heading"><div><div class="eyebrow">WE’RE ON IT</div><h2>Service requests</h2></div></div>
                @forelse ($serviceRequests as $serviceRequest)
                    <div class="request-row"><div><strong>{{ $serviceRequest->service->name }}</strong><span>Sent {{ $serviceRequest->created_at->format('M j, Y') }}</span><p>{{ $serviceRequest->details }}</p></div><span class="status-pill status-{{ $serviceRequest->status }}">{{ str_replace('_', ' ', $serviceRequest->status) }}</span></div>
                @empty
                    <p class="muted-copy">No service requests yet. Tell us what you need and our team will be in touch.</p>
                @endforelse
                <form class="request-form" method="POST" action="{{ route('service-requests.store') }}">@csrf<h3>Start a new request</h3><div class="mb-3"><label class="form-label" for="request_service">Service</label><select class="form-select" name="tax_service_id" id="request_service" required><option value="">Select a service</option>@foreach ($services as $service)<option value="{{ $service->id }}">{{ $service->name }}</option>@endforeach</select></div><div class="mb-3"><label class="form-label" for="request_details">How can we help?</label><textarea class="form-control" name="details" id="request_details" rows="3" maxlength="3000" required></textarea></div><button class="btn btn-outline-dark rounded-pill px-4" type="submit">Send request <span class="ms-2">↗</span></button></form>
            </section>
            <section class="panel-card" id="documents"><div class="panel-heading"><div><div class="eyebrow">SAFE & SOUND</div><h2>Your documents</h2></div></div><p class="muted-copy">Upload PDFs, images, or Word documents (up to 10 MB). Only you can access your files.</p>
                @forelse ($documents as $document)
                    <div class="document-row"><span class="document-icon">↳</span><div><strong>{{ $document->original_name }}</strong><span>{{ number_format($document->size / 1024, 0) }} KB · uploaded {{ $document->created_at->format('M j, Y') }}</span></div><a class="document-action" href="{{ route('documents.download', $document) }}">Download</a><form method="POST" action="{{ route('documents.destroy', $document) }}" onsubmit="return confirm('Remove this document?')">@csrf @method('DELETE')<button class="document-action text-danger" type="submit">Remove</button></form></div>
                @empty
                    <div class="empty-inline">No documents uploaded yet.</div>
                @endforelse
                <form class="upload-form" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">@csrf<label class="form-label" for="document">Add a document</label><div class="upload-controls"><input class="form-control" id="document" name="document" type="file" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required><select class="form-select" name="appointment_id" aria-label="Related appointment"><option value="">No related appointment</option>@foreach ($appointments as $appointment)<option value="{{ $appointment->id }}">{{ $appointment->service->name }} · {{ $appointment->scheduled_at->format('M j') }}</option>@endforeach</select><button class="btn btn-forest rounded-pill px-4" type="submit">Upload</button></div></form>
            </section>
        </div>
        <aside class="dashboard-aside"><section class="panel-card profile-card"><div class="eyebrow">YOUR DETAILS</div><h2>Personal info</h2><form method="POST" action="{{ route('profile.update') }}">@csrf @method('PUT')<div class="mb-3"><label class="form-label" for="profile_name">Full name</label><input class="form-control" id="profile_name" name="name" value="{{ auth()->user()->name }}" required></div><div class="mb-3"><label class="form-label" for="profile_email">Email</label><input class="form-control" id="profile_email" name="email" type="email" value="{{ auth()->user()->email }}" required></div><div class="mb-3"><label class="form-label" for="profile_phone">Phone</label><input class="form-control" id="profile_phone" name="phone" value="{{ auth()->user()->phone }}"></div><div class="mb-3"><label class="form-label" for="profile_address">Address</label><textarea class="form-control" id="profile_address" name="address" rows="3">{{ auth()->user()->address }}</textarea></div><button class="btn btn-outline-dark rounded-pill w-100" type="submit">Update details</button></form></section><div class="help-card"><span>✳</span><h3>Need a hand?</h3><p>Our team is here to make things easier.</p><a href="mailto:hello@clearledger.tax">Get in touch ↗</a></div></aside>
    </div>
</div></section>
@endsection
