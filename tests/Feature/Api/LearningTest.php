<?php

use App\Models\Course;
use App\Models\Learning;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LanguageSeeder;

beforeEach(function() {
    $this->seed(CategorySeeder::class);
    $this->seed(LanguageSeeder::class);

    $this->course = Course::factory([
        'category_id' => 1,
        'language_id' => 1
    ])->create();


    $this->learning = Learning::create([
        'content' => fake()->text(),
        'course_id' => $this->course->id
    ]);
});

it('can create a learning of course', function () {
    authUser();

    $data = [
        'content' => fake()->text()
    ];

    $this->postJson(route('api.learnings.store', $this->course->slug), $data)
        ->assertCreated();

    $this->assertDatabaseHas('learnings', $data);
});

it('fails to create due a missing data', function() {
    authUser();

    $this->postJson(route('api.learnings.store', $this->course->slug), [])
        ->assertStatus(422);
});

it('fails to create due wrong data type', function() {
    authUser();

    $data = [
        'content' => true
    ];

    $this->postJson(route('api.learnings.store', $this->course->slug), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The content field must be a string."
        ]);

    $this->assertDatabaseMissing('learnings', $data);
});

it('can update a learning of course', function () {
    authUser();

    $data = [
        'content' => fake()->text()
    ];

    $this->putJson(route('api.learnings.update', [
        $this->course->slug,
        $this->learning->id
    ]), $data)
        ->assertOk();

    $this->assertDatabaseHas('learnings', $data);
});

it('fails to update duw a missing data', function() {
    authUser();

    $this->putJson(route('api.learnings.update', [
        $this->course->slug,
        $this->learning->id
    ]), [])
        ->assertStatus(422);
});

it('fails to update due wrong data type', function() {
    authUser();

    $data = [
        'content' => true
    ];

    $this->putJson(route('api.learnings.update', [
        $this->course->slug,
        $this->learning->id
    ]), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The content field must be a string."
        ]);

    $this->assertDatabaseMissing('learnings', $data);
});

it('can delete a learning', function() {
    authUser();

    $this->deleteJson(route('api.learnings.destroy', [
        $this->course->slug,
        $this->learning->id
    ]))->assertOk();

    $this->assertDatabaseMissing('learnings', $this->learning->toArray());
});

it('fails to delete if learning id is incorrect', function() {
    authUser();

    $this->deleteJson(route('api.learnings.destroy', [
        $this->course->slug,
        65
    ]))->assertNotFound();
});