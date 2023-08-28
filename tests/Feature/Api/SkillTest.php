<?php

use App\Models\Skill;

it('has skills page', function () {
    authUser();

    $this->getJson(route('api.skills.index'))
        ->assertOk()
        ->assertJsonStructure([
            'message',
            'data' => [
                'skills'
            ]
        ]);
});

it('can create a skill', function() {
    authUser();

    $data = [
        'name' => fake()->sentence
    ];

    $this->postJson(route('api.skills.store'), $data)
        ->assertCreated();

    $this->assertDatabaseHas('skills', $data);
});

it('fails to create due a missing data', function() {
    authUser();

    $this->postJson(route('api.skills.store'), [])
        ->assertStatus(422);

    $this->assertDatabaseMissing('skills', [
        'id' => 2
    ]);
});

it('fails to create due to wrong data type', function() {
    authUser();

    $data = [
        'name' => [12]
    ];

    $this->postJson(route('api.skills.store'), $data)
        ->assertStatus(422);

    $this->assertDatabaseMissing('skills', [
        'id' => 2
    ]);
});

it('can update a skill', function() {
    authUser();

    $skill = Skill::create([
        'name' => fake()->sentence
    ]);

    $data = [
        'name' => fake()->sentence
    ];

    $this->putJson(route('api.skills.update', $skill->id), $data)
        ->assertOk();

    $this->assertDatabaseHas('skills', $data);
});

it('fails to update due a missing data', function() {
    authUser();

    $skill = Skill::create([
        'name' => fake()->sentence
    ]);

    $this->putJson(route('api.skills.update', $skill->id), [])
        ->assertStatus(422);
});

it('fails to update due to wrong data type', function() {
    authUser();

    $skill = Skill::create([
        'name' => fake()->sentence
    ]);

    $data = [
        'name' => [12]
    ];

    $this->putJson(route('api.skills.update', $skill->id), $data)
        ->assertStatus(422);
});

it('can delete a skill', function() {
    authUser();

    $skill = Skill::create([
        'name' => fake()->sentence
    ]);

    $this->deleteJson(route('api.skills.destroy', $skill->id))
        ->assertOk();

    $this->assertDatabaseMissing('skills', $skill->toArray());
});