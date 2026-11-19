<?php

namespace App\Http\Controllers;

use App\Models\CustomerDocument;
use App\Models\TaxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'appointments' => $user->appointments()->with('service')->latest('scheduled_at')->get(),
            'documents' => $user->documents()->with('appointment.service')->latest()->get(),
            'serviceRequests' => $user->serviceRequests()->with('service')->latest()->get(),
            'services' => TaxService::where('active', true)->orderBy('name')->get(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$request->user()->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);
        $request->user()->update($validated);

        return back()->with('success', 'Your profile has been updated.');
    }

    public function storeDocument(Request $request)
    {
        $validated = $request->validate([
            'document' => ['required', 'file', 'max:10240', 'mimes:pdf,jpg,jpeg,png,doc,docx'],
            'appointment_id' => ['nullable', 'integer', 'exists:appointments,id'],
        ]);

        if (! empty($validated['appointment_id'])) {
            abort_unless($request->user()->appointments()->whereKey($validated['appointment_id'])->exists(), 403);
        }

        $file = $validated['document'];
        $path = $file->store('customer-documents/'.$request->user()->id, 'local');
        $request->user()->documents()->create([
            'appointment_id' => $validated['appointment_id'] ?? null,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
            'size' => $file->getSize(),
        ]);

        return back()->with('success', 'Your document was uploaded securely.');
    }

    public function downloadDocument(Request $request, CustomerDocument $document)
    {
        abort_unless($document->user_id === $request->user()->id, 404);

        return Storage::disk('local')->download($document->path, $document->original_name);
    }

    public function destroyDocument(Request $request, CustomerDocument $document)
    {
        abort_unless($document->user_id === $request->user()->id, 404);
        Storage::disk('local')->delete($document->path);
        $document->delete();

        return back()->with('success', 'The document has been removed.');
    }

    public function storeServiceRequest(Request $request)
    {
        $validated = $request->validate([
            'tax_service_id' => ['required', 'integer', 'exists:tax_services,id'],
            'details' => ['required', 'string', 'max:3000'],
        ]);
        abort_unless(TaxService::whereKey($validated['tax_service_id'])->where('active', true)->exists(), 422);

        $request->user()->serviceRequests()->create($validated);

        return back()->with('success', 'Your service request has been sent to our team.');
    }
}
