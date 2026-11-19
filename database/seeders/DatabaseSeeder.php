<?php

namespace Database\Seeders;

use App\Models\TaxService;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Tax consultation', 'slug' => 'tax-consultation', 'category' => 'PERSONAL TAX', 'summary' => 'Clear answers to your most important tax questions.', 'description' => 'Meet one-on-one with an experienced tax professional to get clear, practical guidance for your situation. We can help you understand your obligations, deductions, deadlines, and next steps.', 'price_from' => 22500, 'duration_minutes' => 45],
            ['name' => 'Personal tax filing', 'slug' => 'personal-tax-filing', 'category' => 'PERSONAL TAX', 'summary' => 'Accurate returns, filed with confidence and care.', 'description' => 'We prepare and review your individual tax return, make sure eligible credits and deductions are considered, and help you understand the final numbers before filing.', 'price_from' => 36000, 'duration_minutes' => 60],
            ['name' => 'Tax registration', 'slug' => 'tax-registration', 'category' => 'GETTING STARTED', 'summary' => 'Get registered correctly, without the guesswork.', 'description' => 'Get help with tax identification, business tax registrations, and the paperwork needed to start meeting your tax responsibilities on time.', 'price_from' => 28500, 'duration_minutes' => 45],
            ['name' => 'Tax planning', 'slug' => 'tax-planning', 'category' => 'YEAR-ROUND CARE', 'summary' => 'Make informed decisions before tax season arrives.', 'description' => 'Plan ahead with a tailored review of your income, goals, and upcoming decisions. We identify opportunities and build a straightforward plan for the year ahead.', 'price_from' => 45000, 'duration_minutes' => 60],
            ['name' => 'Business tax services', 'slug' => 'business-tax-services', 'category' => 'FOR BUSINESS', 'summary' => 'Reliable tax support for your growing business.', 'description' => 'From small business returns to ongoing compliance support, we help business owners stay organized, understand their obligations, and focus on running their business.', 'price_from' => 75000, 'duration_minutes' => 75],
        ];

        foreach ($services as $service) {
            TaxService::updateOrCreate(['slug' => $service['slug']], [...$service, 'active' => true]);
        }

        if (env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            User::updateOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                [
                    'name' => env('ADMIN_NAME', 'ClearLedger Admin'),
                    'password' => Hash::make(env('ADMIN_PASSWORD')),
                    'role' => 'admin',
                ]
            );
        }
    }
}
