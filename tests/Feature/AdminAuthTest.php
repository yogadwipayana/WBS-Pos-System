<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test admin
        Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true
        ]);
    }

    public function test_admin_can_view_login_page()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertViewIs('admin.login');
    }

    public function test_admin_can_login_with_correct_credentials()
    {
        $response = $this->withSession(['_token' => 'test'])
            ->post('/login', [
                '_token' => 'test',
                'email' => 'admin@test.com',
                'password' => 'password'
            ]);

        $response->assertRedirect('/dashboard');
        $this->assertTrue(session()->has('admin_logged_in'));
        $this->assertEquals('admin@test.com', session('admin_email'));
    }

    public function test_admin_cannot_login_with_incorrect_password()
    {
        $response = $this->withSession(['_token' => 'test'])
            ->post('/login', [
                '_token' => 'test',
                'email' => 'admin@test.com',
                'password' => 'wrongpassword'
            ]);

        $response->assertSessionHasErrors('login');
        $this->assertFalse(session()->has('admin_logged_in'));
    }

    public function test_admin_cannot_access_dashboard_without_login()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard_after_login()
    {
        $this->withSession(['_token' => 'test'])
            ->post('/login', [
                '_token' => 'test',
                'email' => 'admin@test.com',
                'password' => 'password'
            ]);

        $response = $this->get('/dashboard');
        $response->assertStatus(200);
    }

    public function test_admin_can_logout()
    {
        $this->withSession(['_token' => 'test'])
            ->post('/login', [
                '_token' => 'test',
                'email' => 'admin@test.com',
                'password' => 'password'
            ]);

        $response = $this->withSession(['_token' => 'test'])
            ->post('/admin/logout', ['_token' => 'test']);

        $response->assertRedirect('/login');
        $this->assertFalse(session()->has('admin_logged_in'));
    }
}
