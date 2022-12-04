<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class PostControllerTest extends TestCase
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
    public function test_access_post_index()
    {
        $this->get('/posts')
            ->assertStatus(200)
            ->assertSeeText('Latest Post');
    }

    /** @test */
    public function test_access_create_post_page()
    {
        $this->get('/posts/create')
            ->assertStatus(200)
            ->assertSeeText('Create New Post');
    }

    /** @test */
    public function test_store_new_post()
    {
        $this->post('/posts', [
            'title' => 'New Post',
            'content' => 'New Post Body',
        ]);
    }
}