<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuleController extends Controller
{
    use HttpResponses;

    public function store(Request $request, Course $course): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'skills' => 'array'
        ])->validate();

        $module = Module::create([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $course->id
        ]);

        $module->skills()->syncWithoutDetaching($request->skills);

        return $this->success(code: 201);
    }

    public function update(Request $request, Course $course, Module $module): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'skills' => 'array'
        ]);

        $data->validate();

        $module->update([
            'name' => $request->name,
            'description' => $request->description,
            'course_id' => $course->id
        ]);

        $module->skills()->syncWithoutDetaching($request->skills);

        return $this->success();
    }

    public function destroy(Course $course, Module $module): JsonResponse
    {
        $module->delete();

        return $this->success();
    }
}
