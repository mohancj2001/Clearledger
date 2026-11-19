<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\TaxService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TaxServiceApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_and_service_details_are_available_to_guests(): void
    {
        $service = $this->createService();

        $this->get(route('home'))->assertOk()->assertSee('Tax season,');
        $this->get(route('services.index'))->assertOk()->assertSee($service->name);
        $this->get(route('services.show', $service))
            ->assertOk()
            ->assertSee($service->description)
            ->assertSee('LKR 75');
    }

    public function test_customer_can_register_and_request_an_appointment(): void
    {
        $service = $this->createService();
        $this->post(route('register.store'), [
            'name' => 'Taylor Customer',
            'email' => 'taylor@example.com',
            'password' => 'correct-horse-battery-staple',
            'password_confirmation' => 'correct-horse-battery-staple',
        ])->assertRedirect(route('dashboard'));
        $user = User::where('email', 'taylor@example.com')->firstOrFail();

        $this->actingAs($user)->post(route('appointments.store'), [
            'tax_service_id' => $service->id,
            'scheduled_at' => now()->addDays(3)->format('Y-m-d H:i:s'),
            'notes' => 'Please bring my filing history.',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'tax_service_id' => $service->id,
            'status' => 'pending',
        ]);
    }

    public function test_customer_can_upload_and_only_access_their_own_documents(): void
    {
        Storage::fake('local');
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)->post(route('documents.store'), [
            'document' => UploadedFile::fake()->create('return.pdf', 120, 'application/pdf'),
        ])->assertRedirect();

        $document = $user->documents()->firstOrFail();
        Storage::disk('local')->assertExists($document->path);

        $this->actingAs($otherUser)->get(route('documents.download', $document))->assertNotFound();
        $this->actingAs($user)->get(route('documents.download', $document))->assertOk();
    }

    public function test_admin_can_manage_appointments_but_customers_cannot_open_admin_dashboard(): void
    {
        $service = $this->createService();
        $customer = User::factory()->create();
        $appointment = Appointment::create([
            'user_id' => $customer->id,
            'tax_service_id' => $service->id,
            'scheduled_at' => now()->addDays(3),
            'status' => 'pending',
        ]);

        $this->actingAs($customer)->get(route('admin.index'))->assertForbidden();

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.index'))->assertOk();
        $this->actingAs($admin)->patch(route('admin.appointments.update', $appointment), [
            'status' => 'confirmed',
        ])->assertRedirect();

        $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'status' => 'confirmed']);
    }

    public function test_admin_login_redirects_to_the_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'administrator-password']);

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'administrator-password',
        ])->assertRedirect(route('admin.index'));
    }

    private function createService(): TaxService
    {
        return TaxService::create([
            'name' => 'Tax consultation',
            'slug' => 'tax-consultation',
            'category' => 'PERSONAL TAX',
            'summary' => 'Clear tax advice.',
            'description' => 'Talk through your tax questions.',
            'price_from' => 75,
            'duration_minutes' => 45,
            'active' => true,
        ]);
    }
}
