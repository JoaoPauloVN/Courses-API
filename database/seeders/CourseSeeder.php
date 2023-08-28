<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Learning;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Course::factory()
                ->count(20)
                ->create()
                ->each(function($course) {

                    Module::factory([
                            'course_id' => $course->id
                        ])
                        ->count(random_int(1, 3))
                        ->create()
                        ->each(function($module) {

                            Lesson::factory([
                                'module_id' => $module->id
                                ])
                                ->count(random_int(12, 20))
                                ->create();

                            $module->skills()->attach([1]);
                        });

                    Learning::factory([
                            'course_id' => $course->id
                        ])
                        ->count(random_int(2, 3))
                        ->create();

                    

                    $course->instructors()->attach([1], [
                        'head_instructor' => false
                    ]);

                    $course->users()->attach([1], [
                        'status' => 1
                    ]);
                });
    }
}
