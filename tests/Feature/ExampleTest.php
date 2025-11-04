<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_employee_listing(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('employees.index'));

        $response->assertOk();
    }
}
