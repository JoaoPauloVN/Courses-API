<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Trait\HttpResponses;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->success([
            'access_token' => $user->createToken('access_token')->plainTextToken
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if(!Auth::attempt($request->validated())) {
            return $this->response(__('auth.failed'), code: 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->success([
            'access_token' => $user->createToken('access_token')->plainTextToken
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success();
    }
}