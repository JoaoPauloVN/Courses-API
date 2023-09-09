<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    use HttpResponses;

    public function index(): JsonResponse
    {
        $skills = Skill::get();

        return $this->success([
            'skills' => $skills
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string',
        ])->validate();

        Skill::create($data);

        return $this->success(code: 201);
    }

    public function update(Request $request, Skill $skill): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string',
        ])->validate();

        $skill->update($data);

        return $this->success();
    }

    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();

        return $this->success();
    }
}
