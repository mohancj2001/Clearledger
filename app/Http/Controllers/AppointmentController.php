<?php

namespace App\Http\Controllers;

use App\Models\TaxService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create(Request $request)
    {
        $services = TaxService::where('active', true)->orderBy('name')->get();
        $selectedService = $request->query('service');

        return view('appointments.create', compact('services', 'selectedService'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tax_service_id' => ['required', 'integer', 'exists:tax_services,id'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
        abort_unless(TaxService::whereKey($validated['tax_service_id'])->where('active', true)->exists(), 422);

        $appointment = $request->user()->appointments()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Your appointment request is in. We’ll confirm it shortly. Reference #'.$appointment->id.'.');
    }
}
