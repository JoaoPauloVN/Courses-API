<?php

use App\Models\User;

it('has instructor page', function () {
    authUser();

    $instructor = User::factory()->create();

    $this->getJson(route('api.instructor.show', $instructor->slug))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                'instructor' => [
                    'name'
                ]
            ]
        ]);
});

it('fails if the instructor name is invalid and return 404', function () {
    authUser();

    User::factory()->create();

    $this->getJson(route('api.instructor.show', 'any instructor name'))
        ->assertNotFound();
});
