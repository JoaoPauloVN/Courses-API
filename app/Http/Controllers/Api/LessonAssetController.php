<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonAsset;
use App\Trait\File;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LessonAssetController extends Controller
{
    use HttpResponses, File;

    public function store(Request $request, $course, $module, Lesson $lesson): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'file' => 'required|file|mimes:pdf|max:2048'
        ]);

        $validator->validate();

        $fileName = $this->storeFile($request->file);

        LessonAsset::create([
            'name' => $request->name,
            'file' => $fileName,
            'lesson_id' => $lesson->id
        ]);

        return $this->success(code: 201);
    }

    public function update(Request $request, $course, $module, $lesson, LessonAsset $asset): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'file' => 'required|file|size:3000'
        ]);

        $validator->validate();

        $fileName = $this->replaceFile($request->file, $asset->file);

        $asset->update([
            'name' => $validator->safe()->only('name'),
            'file' => $fileName
        ]);

        return $this->success();
    }

    public function destroy($course, $module, $lesson, LessonAsset $asset): JsonResponse
    {
        $this->deleteFile($asset->file);
        
        $asset->delete();

        return $this->success();
    }
}
