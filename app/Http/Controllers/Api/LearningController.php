<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Learning;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LearningController extends Controller
{
    use HttpResponses;
    
    public function store(Request $request, Course $course): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'content' => 'required|string',
        ])->validate();

        Learning::create([
            'content' => $request->content,
            'course_id' => $course->id
        ]);

        return $this->success(code: 201);
    }

    public function update(Request $request, Course $course, Learning $learning): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'content' => 'required|string',
        ])->validate();

        $learning->update([
            'content' => $request->content,
            'course_id' => $course->id
        ]);

        return $this->success();
    }

    public function destroy($course, Learning $learning): JsonResponse
    {
        $learning->delete();

        return $this->success();
    }
}
