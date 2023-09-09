<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\SimpleCourseResource;
use App\Http\Resources\SimpleUserResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use HttpResponses;

    public function index(): JsonResponse
    {
        $courses = Course::get();

        Spatie\DbDumper\Databases\MySql::create()
            ->setDbName('courses_api')
            ->setUserName('root')
            ->setPassword('')
            ->dumpToFile('dump.sql');

        return $this->success(['courses' => SimpleCourseResource::collection($courses->load([
            'instructors',
        ]))]);
    }

    public function store(CourseRequest $request): JsonResponse
    {
        Course::create($request->validated());

        return $this->success(code: 201);
    }

    public function show(Course $course): JsonResponse
    {
        return $this->success([
            'course' => new CourseResource($course->load([
                'instructors',
                'learnings:id,content',
                'reviews',
                'students',
                'modules' => [
                    'lessons',
                    'skills'
                    ]
            ]))
        ]);
    }

    public function update(CourseRequest $request, Course $course): JsonResponse
    {
        $course->update($request->validated());

        return $this->success([$course]);
    }

    public function destroy(Course $course): JsonResponse
    {
        $course->delete();

        return $this->success();
    }

    public function currentLesson(Request $request, Course $course)
    {
        $lesson = $course->currentLesson($request->user()->id);

        if($lesson) {          
            return redirect(route('api.courses.lesson', [
                $course->id,
                $lesson->slug
            ]));
        } else {
            return $this->success([
                __('generic.course_without_lessons')
            ]);
        }
    }

    public function lesson(Request $request, Course $course, Lesson $lesson): JsonResponse
    {
        $userData = $lesson->userStatus($request->user()->id);

        if(!$userData) {
            $lesson->user()->attach($request->user()->id, [
                'complete' => 0
            ]);
        }
        
        return $this->success([
            'course' => new CourseResource($course->load([
                'instructors',
                'learnings:id,content',
                'reviews',
                'students',
                'modules' => [
                    'lessons',
                    'skills'
                    ]
            ])),
            'lesson' => new LessonResource($lesson),
            'links' => [
                'prev' => $lesson->prevLesson($course),
                'next' => $lesson->nextLesson($course)
            ]
        ]);
    }

    public function users(Course $course)
    {
        $users = $course->load('users')->users;

        return $this->success([
            'users' => SimpleUserResource::collection($users),
            'count' => $users->count()
        ]);
    }

    public function subscribe(Course $course, User $user)
    {
        $course->users()->syncWithoutDetaching([$user->id => [
            'status' => 1
        ]]);

        return $this->success();
    }

    public function unsubscribe(Request $request, Course $course)
    {
        $course->users()->syncWithoutDetaching([$request->user()->id => [
            'status' => 0
        ]]);

        return $this->success();
    }

    public function review(Request $request, Course $course)
    {
        $course->reviews()->syncWithoutDetaching([$request->user()->id => [
            'rating' => $request->rating,
            'comment' => $request->comment
        ]]);

        return $this->success();
    }
}
