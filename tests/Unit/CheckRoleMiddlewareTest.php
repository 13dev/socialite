<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminAuthorized()
    {
        $this->actingAsAdmin()
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }

    public function testAdminForbidden()
    {
        $this->actingAsUser()
            ->get('/admin/dashboard')
            ->assertRedirect('/');

        $this->assertEquals(session('errors')->first(), 'Not authorized.');
    }
}
