<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Database\Seeders\CategorySeeder;
use Database\Seeders\LanguageSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

it('guess users cant create lessons', function() {
    $route = route('api.lessons.store', [
        $this->course->slug,
        $this->module->slug,
    ]);

    $this->postJson($route)->assertStatus(401);
});

it('can create a lesson', function () {
    authUser();

    $route = route('api.lessons.store', [
        $this->course->slug,
        $this->module->slug,
    ]);

    $data = [
        'name' => fake()->sentence(),
        'type' => 'video'
    ];

    $this->postJson($route, $data)
        ->assertCreated();

    $this->assertDatabaseHas('lessons', $data);
});

it('fails to create due a missing data', function() {
    authUser();

    $this->postJson(route('api.lessons.store', [
        $this->course->slug,
        $this->module->slug,
    ]), [])->assertStatus(422);
});

it('fails to create due wrong data type', function() {
    authUser();

    $data = [
        'name' => [],
        'type' => false
    ];

    $this->postJson(route('api.lessons.store', [
        $this->course->slug,
        $this->module->slug,
    ]), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field is required. (and 1 more error)"
        ]);

    $this->assertDatabaseMissing('lessons', $data);
});

it('can update a lesson', function () {
    authUser();

    $route = route('api.lessons.update', [
        $this->course->slug,
        $this->module->slug,
        $this->lesson->slug
    ]);

    $data = [
        'name' => fake()->sentence(),
        'type' => 'video'
    ];

    $this->putJson($route, $data)
        ->assertOk();

    $this->assertDatabaseHas('lessons', $data);
});


it('fails to update duw a missing data', function() {
    authUser();

    $this->putJson(route('api.lessons.update', [
        $this->course->slug,
        $this->module->slug,
        $this->lesson->slug
    ]), [])
        ->assertStatus(422);
});

it('fails to update due wrong data type', function() {
    authUser();

    $data = [
        'name' => [],
        'type' => false
    ];

    $this->putJson(route('api.lessons.update', [
        $this->course->slug,
        $this->module->slug,
        $this->lesson->slug
    ]), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field must be a string. (and 1 more error)"
        ]);

    $this->assertDatabaseMissing('lessons', $data);
});

it('can delete a lesson', function () {
    authUser();

    $route = route('api.lessons.destroy', [
        $this->course->slug,
        $this->module->slug,
        $this->lesson->slug
    ]);

    $this->deleteJson($route)
        ->assertOk();

    $this->assertDatabaseMissing('lessons', [
        'id' => $this->lesson->id
    ]);
});

it('fails to delete if lesson slug is incorrect', function() {
    authUser();

    $this->deleteJson(route('api.lessons.destroy', [
        $this->course->slug,
        $this->module->slug,
        'any lesson'
    ]))->assertNotFound();
});

it('can create and delete an asset for a lesson', function() {
    Storage::fake('public');
    authUser();

    $route = route('api.assets.store', [
        $this->course->slug,
        $this->module->slug,
        $this->lesson->slug
    ]);

    $file = UploadedFile::fake()->create('test.pdf', 1024);

    $this->postJson($route, [
        'name' => 'test',
        'file' => $file
    ])
        ->assertCreated();

    $asset = $this->lesson->load('assets')->assets->first();

    Storage::disk('public')->assertExists('files/' . $asset->file);

    $data = [
        'name' => 'test',
        'file' => $asset->file
    ];

    $this->assertDatabaseHas('lesson_assets', $data);

    // Delete Asset logic

    $route = route('api.assets.destroy', [
        $this->course->slug,
        $this->module->slug,
        $this->lesson->slug,
        $asset->id
    ]);

    $this->deleteJson($route)
        ->assertOk();

    $this->assertDatabaseMissing('lesson_assets', $data);

    Storage::disk('public')->assertMissing('files/' . $asset->file);
});