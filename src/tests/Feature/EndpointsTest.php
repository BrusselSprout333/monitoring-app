<?php

namespace Tests\Feature;

use Tests\TestCase;

class EndpointsTest extends TestCase
{
    public function test_can_see_main_page_on_root(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Users');
        $response->assertViewIs('usersList');
    }

    public function test_can_see_main_page(): void
    {
        $response = $this->get('/users');

        $response->assertStatus(200);
        $response->assertSee('Users');
        $response->assertViewIs('usersList');
    }

    public function test_can_see_create_page(): void
    {
        $response = $this->get('/users/create');

        $response->assertStatus(200);
        $response->assertSee('Create User');
        $response->assertViewIs('createUser');
    }

    public function test_can_see_page_with_user_data(): void
    {
        $response = $this->get('/users/2');

        $response->assertStatus(200);
        $response->assertSee('User');
        $response->assertViewIs('userData');
    }
}

