<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class CategoryControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->count(1)->make();

        $user = User::first();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
    }

    /** @test */
    public function test_access_category_index()
    {
        $this->get('/categories')
            ->assertStatus(200)
            ->assertSeeText('Latest Categories');
    }

    /** @test */
    public function test_access_create_category_page()
    {
        $this->get('/categories/create')
            ->assertStatus(200)
            ->assertSeeText('Create New Category');
    }
}