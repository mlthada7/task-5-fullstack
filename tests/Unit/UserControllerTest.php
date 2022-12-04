<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    /** @test */
    public function test_user_can_access_login_page()
    {
        $this->get('/login')
            ->assertStatus(200)
            ->assertSeeText('Login');
    }

    /** @test */
    public function test_user_duplication()
    {
        $user1 = User::make([
            'name' => 'John Doe',
            'email' => 'johndoe@gmail.com',
        ]);
        $user2 = User::make([
            'name' => 'Jane',
            'email' => 'jane@gmail.com',
        ]);

        $this->assertTrue($user1->name != $user2->name);
    }


    /** @test */
    public function test_user_login_success()
    {
        $user = User::factory()->count(1)->make();

        $user = User::first();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect('/posts');
    }

    /** @test */
    public function test_user_login_with_wrong_password()
    {
        $user = User::factory()->count(1)->make();

        $user = User::first();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'thisiswrongpassword',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function test_user_can_access_register_page()
    {
        $this->get('/register')
            ->assertStatus(200)
            ->assertSeeText('Register');
    }

    /** @test */
    public function test_register_new_user_success()
    {
        $response = $this->post('/register', [
            'name' => 'johndoe',
            'email' => 'johndoe@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/posts');
    }
}