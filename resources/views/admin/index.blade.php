@extends('layouts.app')
@section('title', 'Admin dashboard')
@section('content')
<section class="dashboard-head">
    <div class="container dashboard-head-inner">
        <div>
            <div class="eyebrow">CLEARLEDGER OPERATIONS</div>
            <h1>Admin <em>dashboard.</em></h1>
            <p>Manage services, customers, appointments, and incoming requests.</p>
        </div><a class="btn btn-outline-dark rounded-pill px-4" href="{{ route('home') }}">View website <span class="ms-2">↗</span></a>
    </div>
</section>
<section class="section-pad dashboard-section">
    <div class="container">
        <div class="dashboard-summary admin-stats">
            <div><span class="summary-label">CUSTOMERS</span><strong>{{ $stats['customers'] }}</strong><small>registered accounts</small></div>
            <div><span class="summary-label">APPOINTMENTS</span><strong>{{ $stats['appointments'] }}</strong><small>{{ $stats['pending'] }} awaiting confirmation</small></div>
            <div><span class="summary-label">OPEN REQUESTS</span><strong>{{ $stats['requests'] }}</strong><small>need attention</small></div>
            <div><span class="summary-label">ACTIVE SERVICES</span><strong>{{ $services->where('active', true)->count() }}</strong><small>available to customers</small></div>
        </div>
        <section class="panel-card admin-panel">
            <div class="panel-heading">
                <div>
                    <div class="eyebrow">YOUR OFFERING</div>
                    <h2>Tax services</h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Price from (LKR)</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th>Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $service)
                        <tr>
                            <td><strong>{{ $service->name }}</strong><small>{{ $service->category }}</small></td>
                            <td>LKR {{ number_format($service->price_from) }}</td>
                            <td>{{ $service->duration_minutes }} min</td>
                            <td><span class="status-pill {{ $service->active ? 'status-confirmed' : 'status-cancelled' }}">{{ $service->active ? 'Active' : 'Inactive' }}</span></td>
                            <td>
                                <details class="edit-service">
                                    <summary>Edit</summary>
                                    <form method="POST" action="{{ route('admin.services.update', $service) }}">@csrf @method('PUT')@include('admin.service-fields', ['service' => $service])<button class="btn btn-forest btn-sm rounded-pill px-3" type="submit">Save changes</button></form>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="mt-2" onsubmit="return confirm('Delete this service?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger rounded-pill px-3" type="submit">Delete service</button></form>
                                </details>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <details class="add-service">
                <summary>+ Add a tax service</summary>
                <form method="POST" action="{{ route('admin.services.store') }}" class="admin-form-grid">@csrf @include('admin.service-fields', ['service' => null])<button class="btn btn-forest rounded-pill px-4 align-self-end" type="submit">Add service</button></form>
            </details>
        </section>
        <section class="panel-card admin-panel">
            <div class="panel-heading">
                <div>
                    <div class="eyebrow">CLIENT CALENDAR</div>
                    <h2>Appointments</h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Date & time</th>
                            <th>Status</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>@forelse ($appointments as $appointment)<tr>
                            <td><strong>{{ $appointment->user->name }}</strong><small>{{ $appointment->user->email }}</small></td>
                            <td>{{ $appointment->service->name }}</td>
                            <td>{{ $appointment->scheduled_at->format('M j, Y · g:i A') }}</td>
                            <td><span class="status-pill status-{{ $appointment->status }}">{{ str_replace('_', ' ', $appointment->status) }}</span></td>
                            <td>
                                <form class="status-form" method="POST" action="{{ route('admin.appointments.update', $appointment) }}">@csrf @method('PATCH')<select class="form-select form-select-sm" name="status" aria-label="Appointment status">@foreach (['pending','confirmed','completed','cancelled'] as $status)<option value="{{ $status }}" @selected($appointment->status === $status)>{{ ucfirst($status) }}</option>@endforeach</select><button class="btn btn-sm btn-outline-dark rounded-pill" type="submit">Save</button></form>
                            </td>
                        </tr>@empty<tr>
                            <td colspan="5" class="empty-inline">No appointments yet.</td>
                        </tr>@endforelse</tbody>
                </table>
            </div>{{ $appointments->links() }}
        </section>
        <section class="panel-card admin-panel">
            <div class="panel-heading">
                <div>
                    <div class="eyebrow">CUSTOMER CARE</div>
                    <h2>Service requests</h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Request</th>
                            <th>Status</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>@forelse ($requests as $serviceRequest)<tr>
                            <td><strong>{{ $serviceRequest->user->name }}</strong><small>{{ $serviceRequest->user->email }}</small></td>
                            <td>{{ $serviceRequest->service->name }}</td>
                            <td class="request-details-cell">{{ $serviceRequest->details }}</td>
                            <td><span class="status-pill status-{{ $serviceRequest->status }}">{{ str_replace('_', ' ', $serviceRequest->status) }}</span></td>
                            <td>
                                <form class="status-form" method="POST" action="{{ route('admin.requests.update', $serviceRequest) }}">@csrf @method('PATCH')<select class="form-select form-select-sm" name="status" aria-label="Request status">@foreach (['received','in_review','in_progress','completed','cancelled'] as $status)<option value="{{ $status }}" @selected($serviceRequest->status === $status)>{{ ucwords(str_replace('_', ' ', $status)) }}</option>@endforeach</select><button class="btn btn-sm btn-outline-dark rounded-pill" type="submit">Save</button></form>
                            </td>
                        </tr>@empty<tr>
                            <td colspan="5" class="empty-inline">No service requests yet.</td>
                        </tr>@endforelse</tbody>
                </table>
            </div>{{ $requests->links() }}
        </section>
        <section class="panel-card admin-panel">
            <div class="panel-heading">
                <div>
                    <div class="eyebrow">YOUR COMMUNITY</div>
                    <h2>Registered customers</h2>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>@forelse ($customers as $customer)<tr>
                            <td><strong>{{ $customer->name }}</strong></td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone ?: '—' }}</td>
                            <td>{{ $customer->created_at->format('M j, Y') }}</td>
                        </tr>@empty<tr>
                            <td colspan="4" class="empty-inline">No customers registered yet.</td>
                        </tr>@endforelse</tbody>
                </table>
            </div>{{ $customers->links() }}
        </section>
    </div>
</section>
@endsection