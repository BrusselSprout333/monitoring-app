<?php

namespace Tests\Feature;

use Tests\TestCase;

class EndpointsTest extends TestCase
{
    public function testCanSeeMainPageOnRoot(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Users');
        $response->assertViewIs('usersList');
    }

    public function testCanSeeMainPage(): void
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
        $response->assertSee('Users');
        $response->assertViewIs('usersList');
    }

    public function testCanSeeCreatePage(): void
    {
        $response = $this->get('/users/create');

        $response->assertStatus(200);
        $response->assertSee('Create User');
        $response->assertViewIs('createUser');
    }

    public function testCanSeePageWithUserData(): void
    {
        $response = $this->get('/users/2');

        $response->assertStatus(200);
        $response->assertSee('User');
        $response->assertViewIs('userData');
    }
}

