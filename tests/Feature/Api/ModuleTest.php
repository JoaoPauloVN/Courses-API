<?php

use App\Models\Course;
use App\Models\Module;
use App\Models\Skill;
use Database\Seeders\SkillSeeder;

beforeEach(function() {
    $this->seed(LanguageSeeder::class);
    $this->seed(CategorySeeder::class);
    $this->seed(SkillSeeder::class);

    $this->course = Course::factory()->create();
    $this->module = Module::factory([
        'course_id' => $this->course->id
    ])->create();

    $this->skills = Skill::inRandomOrder()->limit(2)->get()->pluck('id')->toArray();
});

it('guess users cant create modules', function() {
    $this->postJson(route('api.modules.store', [
        $this->course->slug
    ]))->assertUnauthorized();
});

it('auth users can create modules', function() {
    authUser();

    $data = [
        'name' => fake()->sentence(),
        'description' => fake()->text()
    ];

    $this->postJson(route('api.modules.store', [
        $this->course->slug
    ]), [
        ...$data,
        'skills' => $this->skills
    ])->assertCreated();


    $this->assertDatabaseHas('modules', $data);

    $this->assertDatabaseHas('module_skill', [
        'module_id' => 2,
        'skill_id' => $this->skills[0]
    ]);
});

it('fails to create due a missing data', function() {
    authUser();

    $this->postJson(route('api.modules.store', $this->course->slug))
        ->assertStatus(422);
});

it('fails to create due wrong data type', function() {
    authUser();

    $data = [
        'name' => true,
        'description' => []
    ];

    $this->postJson(route('api.modules.store', $this->course->slug), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field must be a string. (and 1 more error)",
        ]);

    $this->assertDatabaseMissing('modules', $data);
});

it('auth users can update modules', function() {
    authUser();

    $data = [
        'name' => fake()->sentence(),
        'description' => fake()->text()
    ];

    $this->putJson(route('api.modules.update', [
        $this->course->slug,
        $this->module->slug
    ]), [
        ...$data,
        'skills' => $this->skills
    ])->assertOk();


    $this->assertDatabaseHas('modules', $data);

    $this->assertDatabaseHas('module_skill', [
        'module_id' => $this->module->id,
        'skill_id' => $this->skills[0]
    ]);
});

it('fails to update duw a missing data', function() {
    authUser();

    $this->putJson(route('api.modules.update', [
        $this->course->slug,
        $this->module->slug
    ]), [])
        ->assertStatus(422);
});

it('fails to update due wrong data type', function() {
    authUser();

    $data = [
        'name' => true,
        'description' => []
    ];

    $this->putJson(route('api.modules.update', [
        $this->course->slug,
        $this->module->slug
    ]), $data)
        ->assertStatus(422)
        ->assertJson([
            "message" => "The name field must be a string. (and 1 more error)"
        ]);

    $this->assertDatabaseMissing('modules', $data);
});

it('can delete modules', function() {
    authUser();

    $this->deleteJson(route('api.modules.destroy', [
        $this->course->slug,
        $this->module->slug,
    ]))->assertOk();

    $this->assertDatabaseMissing('modules', $this->module->toArray());
});

it('fails to delete if module slug is incorrect', function() {
    authUser();

    $this->deleteJson(route('api.modules.destroy', [
        $this->course->slug,
        'any course slug'
    ]))->assertNotFound();
});