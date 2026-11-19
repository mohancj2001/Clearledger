<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ServiceRequest;
use App\Models\TaxService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', [
            'customers' => User::where('role', 'customer')->latest()->paginate(8, ['*'], 'customers'),
            'appointments' => Appointment::with(['user', 'service'])->latest('scheduled_at')->paginate(10, ['*'], 'appointments'),
            'requests' => ServiceRequest::with(['user', 'service'])->latest()->paginate(10, ['*'], 'requests'),
            'services' => TaxService::orderBy('name')->get(),
            'stats' => [
                'customers' => User::where('role', 'customer')->count(),
                'appointments' => Appointment::count(),
                'pending' => Appointment::where('status', 'pending')->count(),
                'requests' => ServiceRequest::whereIn('status', ['received', 'in_review'])->count(),
            ],
        ]);
    }

    public function storeService(Request $request)
    {
        $validated = $this->validateService($request);
        $validated['slug'] = Str::slug($validated['name']).'-'.Str::lower(Str::random(5));
        TaxService::create($validated);

        return back()->with('success', 'The service has been added.');
    }

    public function updateService(Request $request, TaxService $service)
    {
        $validated = $this->validateService($request);
        $validated['slug'] = $service->slug;
        $service->update($validated);

        return back()->with('success', 'The service has been updated.');
    }

    public function destroyService(TaxService $service)
    {
        if ($service->appointments()->exists() || $service->serviceRequests()->exists()) {
            return back()->withErrors(['service' => 'This service has customer history, so it cannot be deleted. Deactivate it instead.']);
        }

        $service->delete();

        return back()->with('success', 'The service has been deleted.');
    }

    public function updateAppointment(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ]);
        $appointment->update($validated);

        return back()->with('success', 'Appointment status updated.');
    }

    public function updateRequest(Request $request, ServiceRequest $serviceRequest)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['received', 'in_review', 'in_progress', 'completed', 'cancelled'])],
        ]);
        $serviceRequest->update($validated);

        return back()->with('success', 'Service request status updated.');
    }

    private function validateService(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:80'],
            'summary' => ['required', 'string', 'max:220'],
            'description' => ['required', 'string', 'max:3000'],
            'price_from' => ['required', 'integer', 'min:0', 'max:1000000'],
            'duration_minutes' => ['required', 'integer', 'min:15', 'max:480'],
            'active' => ['required', 'boolean'],
        ]);
    }
}
