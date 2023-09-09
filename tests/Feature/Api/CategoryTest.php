<?php

use App\Models\Category;

beforeEach(function() {
    $this->category = Category::create([
        'name' => fake()->sentence()
    ]);
});

it('show categories correctly', function() {
    authUser();
     
    $this->getJson(route('api.categories.index'))
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'categories'
            ]
        ]);
});

it('can create a category', function() {
    authUser();

    $data = [
        'name' => fake()->sentence(),
    ];

    $this->postJson(route('api.categories.store'), $data)
        ->assertCreated();

    $this->assertDatabaseHas('categories', $data);
});

it('fails to create due a missing data', function() {
    authUser();

    $this->postJson(route('api.categories.store'), [])
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field is required.",
        ]);
});

it('fails to create due to wrong data type', function() {
    authUser();

    $data = [
        'name' => fake()->randomNumber(),
    ];

    $this->postJson(route('api.categories.store'), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field must be a string.",
        ]);

    $this->assertDatabaseMissing('categories', $data);
});

it('can update category', function() {
    authUser();

    $data = [
        'name' => fake()->sentence(),
    ];

    $this->putJson(route('api.categories.update', $this->category->id), $data)
        ->assertOk();

    $this->assertDatabaseHas('categories', $data);
});


it('fails to update due a missing data', function() {
    authUser();

    $this->putJson(route('api.categories.update', $this->category->id), [])
        ->assertStatus(422);
});

it('fails to update due a wrong data type', function() {
    authUser();

    $data = [
        'name' => fake()->randomNumber(),
    ];

    $this->putJson(route('api.categories.update', $this->category->id), $data)
        ->assertStatus(422);

    $this->assertDatabaseMissing('categories', $data);
});

it('can delete category', function() {
    authUser();

    $this->deleteJson(route('api.categories.destroy', $this->category->id))
        ->assertOk();

    $this->assertDatabaseMissing('categories', $this->category->toArray());
});

it('fails to delete if course slug is incorrect', function() {
    authUser();

    $this->deleteJson(route('api.categories.destroy', 'any course slug'))
        ->assertNotFound();
});