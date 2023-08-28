<?php

use App\Enums\DifficultyLevel;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Database\Seeders\LanguageSeeder;

beforeEach(function() {
    $this->seed(LanguageSeeder::class);
    $this->seed(CategorySeeder::class);

    $this->course = Course::factory()->create();

    $this->module = Module::factory([
        'course_id' => $this->course->id
    ])->create();

    $this->lesson = Lesson::factory([
        'module_id' => $this->module->id
    ])->create();
});

it('show courses correctly', function() {
    $this->getJson(route('api.courses.index'))
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'courses'
            ]
        ]);
});

it('can show a course', function() {
    $this->getJson(route('api.courses.show', $this->course->slug))
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'course'
            ]
        ]);
});

it('fails if the course name is invalid and return correctly', function() {
    $this->getJson(route('api.courses.show', 'any course name'))
        ->assertNotFound();
});

it('guess users are unable to create courses', function() {
    $this->postJson(route('api.courses.store'))
        ->assertUnauthorized();
});

it('can create a course', function() {
    authUser();

    $data = [
        'name' => fake()->sentence(),
        'description' => fake()->text(),
        'difficulty_level' => fake()->randomElement(DifficultyLevel::cases()),
        'duration' => fake()->randomNumber(),
        'image_url' => fake()->sentence(),
        'new' => true,
        'free' => true,
        'price' => fake()->randomNumber(),
        'language_id' => 1,
        'category_id' => 1
    ];

    $this->postJson(route('api.courses.store'), $data)
        ->assertCreated();

    $this->assertDatabaseHas('courses', $data);
});

it('fails to create due a missing data', function() {
    authUser();

    $this->postJson(route('api.courses.store'), [])
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field is required. (and 5 more errors)",
        ]);
});

it('fails to create due to wrong data type', function() {
    authUser();

    $data = [
        'name' => fake()->randomNumber(),
        'description' => [],
        'difficulty_level' => true,
        'duration' => true,
        'image_url' => [],
        'new' => fake()->sentence(),
        'free' => fake()->sentence(),
        'price' => false,
        'language_id' => fake()->sentence(),
        'category_id' => fake()->sentence()
    ];

    $this->postJson(route('api.courses.store'), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field must be a string. (and 8 more errors)",
        ]);

    $this->assertDatabaseMissing('courses', $data);
});

it('can update course', function() {
    authUser();
    
    $data = [
        'name' => fake()->sentence(),
        'description' => fake()->text(),
        'difficulty_level' => fake()->randomElement(DifficultyLevel::cases()),
        'duration' => fake()->randomNumber(),
        'image_url' => fake()->sentence(),
        'new' => true,
        'free' => true,
        'price' => fake()->randomNumber(),
        'language_id' => 1,
        'category_id' => 1
    ];

    $this->putJson(route('api.courses.update', $this->course->slug), $data)
        ->assertOk();

    $this->assertDatabaseHas('courses', $data);
});


it('fails to update due a missing data', function() {
    authUser();

    $this->putJson(route('api.courses.update', $this->course->slug), [])
        ->assertStatus(422);
});

it('fails to update due a wrong data type', function() {
    authUser();

    $data = [
        'name' => fake()->randomNumber(),
        'description' => [],
        'difficulty_level' => true,
        'duration' => true,
        'image_url' => [],
        'new' => fake()->sentence(),
        'free' => fake()->sentence(),
        'price' => false,
        'language_id' => fake()->sentence(),
        'category_id' => fake()->sentence()
    ];

    $this->putJson(route('api.courses.update', $this->course->slug), $data)
        ->assertStatus(422);

    $this->assertDatabaseMissing('courses', $data);
});

it('can delete course', function() {
    authUser();

    $this->deleteJson(route('api.courses.destroy', $this->course->slug))
        ->assertOk();

    $this->assertDatabaseMissing('courses', $this->course->toArray());
});

it('fails to delete if course slug is incorrect', function() {
    authUser();

    $this->deleteJson(route('api.courses.destroy', 'any course slug'))
        ->assertNotFound();
});

it('unregistered user cant access the content of the course', function() {
    authUser();

    $this->getJson(route('api.courses.learn', [
        $this->course->slug
        ]))->assertUnauthorized();
});

it('registered user can access the content of the course', function() {
    authUser();

    $user = User::first();

    $this->postJson(route('api.courses.subscribe', [
        $this->course->slug,
        $user->slug
    ]))->assertOk();

    $this->getJson(route('api.courses.learn', [
        $this->course->slug
    ]))->assertRedirect();
});

it('registered user can review the course', function() {
    authUser();

    $user = User::first();

    $this->postJson(route('api.courses.subscribe', [
        $this->course->slug,
        $user->slug
    ]))->assertOk();

    $data = [
        'rating' => 4,
        'comment' => 'test'
    ];

    $this->postJson(route('api.courses.review', $this->course->slug), $data)
        ->assertOk();

    $this->assertDatabaseHas('reviews', [
        'course_id' => $this->course->id,
        ...$data
    ]);
});

it('can get users registered in the course', function() {
    authUser();

    $user = User::first();

    $this->postJson(route('api.courses.subscribe', [
        $this->course->slug,
        $user->slug
    ]))->assertOk();

    $this->getJson(route('api.courses.users', $this->course->slug))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'users',
                'count'
            ]
        ]);
});