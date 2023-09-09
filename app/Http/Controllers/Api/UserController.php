<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\User;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponses;

    public function instructor(User $instructor): JsonResponse
    {
        return $this->success([
            'instructor' => new InstructorResource($instructor)
        ]);
    }
}
