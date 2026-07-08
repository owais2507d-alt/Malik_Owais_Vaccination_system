<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use DatabaseMigrations;

    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_patient_login_page_loads(): void
    {
        $response = $this->get('/patient/login');
        $response->assertStatus(200);
    }

    public function test_patient_register_page_loads(): void
    {
        $response = $this->get('/patient/register');
        $response->assertStatus(200);
    }

    public function test_hospital_login_page_loads(): void
    {
        $response = $this->get('/hospital/login');
        $response->assertStatus(200);
    }

    public function test_hospital_register_page_loads(): void
    {
        $response = $this->get('/hospital/register');
        $response->assertStatus(200);
    }

    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    public function test_patient_dashboard_requires_auth(): void
    {
        $response = $this->get('/patient/dashboard');
        $response->assertRedirect();
    }

    public function test_hospital_dashboard_requires_auth(): void
    {
        $response = $this->get('/hospital/dashboard');
        $response->assertRedirect();
    }

    public function test_admin_dashboard_requires_auth(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect();
    }
}
