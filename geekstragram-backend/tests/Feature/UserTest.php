<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class UserTest extends TestCase
{
    /**
     * Test para el registro
     *
     * @return void
     */
    public function testRegister()
    {
        $user = factory(User::class)->make();
        $response = $this->postJson('/api/v1/register', [
            "user_name" => $user->user_name,
            "email" => $user->email,
            "password"=> $user->password,
            "confirm_password"=> $user->password
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message' => 'Usuario creado con exito',
                'email' => $user->email
            ]);
    }

    /**
     * Test para el login
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(User::class)->make();
        $this->postJson('/api/v1/register', [
            'user_name' => $user->user_name,
            'email' => $user->email,
            'password' => $user->password,
            'confirm_password' => $user->password,
        ]);
        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'email' => $user->email
            ]);
    }
}
