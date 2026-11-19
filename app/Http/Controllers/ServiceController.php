<?php

namespace App\Http\Controllers;

use App\Models\TaxService;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', ['services' => TaxService::where('active', true)->orderBy('id')->get()]);
    }

    public function show(TaxService $service)
    {
        abort_unless($service->active, 404);

        return view('services.show', compact('service'));
    }
}
