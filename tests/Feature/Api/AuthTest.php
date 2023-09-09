<?php

use App\Models\User;

it('can register', function () {
    $data = [
        'name' => fake()->name(),
        'email' => fake()->email(),
        'password' => 'password'
    ];
    
    $this->postJson(route('api.auth.register'), $data)
        ->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'access_token'
                ]
            ]);

    $this->assertCredentials($data);
});

it('fails to register due missing data', function () {
    $data = [
        'name' => fake()->name()
    ];

    $this->postJson(route('api.auth.register'), $data)
        ->assertStatus(422)
        ->assertJson([
            "errors" => [
                "email" => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ]
            ]   
        ]);

    $this->assertDatabaseMissing('users', []);
});

it('fails to register due a wrong data type', function () {
    $data = [
        'name' => 12,
        'email' => [],
        'password' => true
    ];

    $this->postJson(route('api.auth.register'), $data)
        ->assertStatus(422)
        ->assertJson([
            "errors" => [
                "name" => [
                    "The name field must be a string."
                ],
                "email" => [
                    "The email field must be a valid email address.",
                ],
                "password" => [
                    "The password field must be a string."
                ]
            ]   
        ]);

    $this->assertDatabaseMissing('users', []);
});

it('can login', function() {
    $user = User::factory()->create();

    $this->postJson(route('api.auth.login'), [
        'email' => $user->email,
        'password' => 'password'
    ])
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'access_token'
                ]
            ]);
});

it('fails to login due missing data', function () {
    $this->postJson(route('api.auth.register'), [])
        ->assertStatus(422)
        ->assertJson([
            "errors" => [
                "email" => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ]
            ]   
        ]);
});

it('fails to login due a wrong data type', function () {
    $data = [
        'email' => [],
        'password' => true
    ];

    $this->postJson(route('api.auth.register'), $data)
        ->assertStatus(422)
        ->assertJson([
            "errors" => [
                "email" => [
                    "The email field must be a valid email address.",
                ],
                "password" => [
                    "The password field must be a string."
                ]
            ]   
        ]);
});

it('check if the data is incorrect', function () {
    User::factory()->create();

    $data = [
        'email' => 'wrong@email.com',
        'password' => 'password'
    ];

    $this->postJson(route('api.auth.login'), $data)
        ->assertUnauthorized()
        ->assertJson([
            "message" => "These credentials do not match our records."
        ]);
});

it('users are redirect if try login or register', function() {
    authUser();

    $this->postJson(route('api.auth.register'))
        ->assertRedirect();

    $this->postJson(route('api.auth.login'))
        ->assertRedirect();
});

it('users can logout', function() {
    authUser();

    $this->postJson(route('api.auth.logout'))
        ->assertOk()
        ->assertJson(['message' => 'success']);
});

it('guess users are unable to logout', function() {
    $this->postJson(route('api.auth.logout'))
        ->assertStatus(401)
        ->assertJson(['message' => 'Unauthenticated.']);
});
