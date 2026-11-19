<?php

namespace App\Http\Controllers;

use App\Models\TaxService;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', ['services' => TaxService::where('active', true)->orderBy('id')->take(5)->get()]);
    }
}
