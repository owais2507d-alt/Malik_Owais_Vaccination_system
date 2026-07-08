<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PatientAuthTest extends TestCase
{
    use DatabaseMigrations;

    public function test_patient_can_register(): void
    {
        $response = $this->post('/patient/register', [
            'name' => 'Test Patient',
            'email' => 'patient@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/patient/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'patient@test.com',
            'role' => 'patient',
        ]);
    }

    public function test_patient_can_login(): void
    {
        User::create([
            'name' => 'Test Patient',
            'email' => 'patient2@test.com',
            'password' => bcrypt('password123'),
            'role' => 'patient',
        ]);

        $response = $this->post('/patient/login', [
            'email' => 'patient2@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/patient/dashboard');
    }

    public function test_patient_invalid_login(): void
    {
        $response = $this->post('/patient/login', [
            'email' => 'wrong@test.com',
            'password' => 'wrongpass',
        ]);

        $response->assertSessionHas('error');
    }

    public function test_admin_can_login(): void
    {
        User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/admin/login', [
            'email' => 'admin@test.com',
            'password' => 'admin123',
        ]);

        $response->assertRedirect('/admin/dashboard');
    }
}
