<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    use HttpResponses;

    public function store(Request $request, $course, Module $module): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string|max:120',
            'content' => 'string',
            'type' => 'required|string',
            'embed' => 'string',
        ]);

        $data->validate();

        Lesson::create([
            ...$data->validated(),
            'module_id' => $module->id
        ]);

        return $this->success(code: 201);
    }

    public function update(Request $request, $course, $module, Lesson $lesson): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'string',
            'content' => 'string',
            'type' => 'required|string',
            'embed' => 'string',
        ]);
        $data->validate();

        $lesson->update($data->validated());

        return $this->success();
    }

    public function destroy($course, $module, Lesson $lesson): JsonResponse
    {
        $lesson->delete();

        return $this->success();
    }
}
