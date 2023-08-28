<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Trait\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use HttpResponses;

    public function index(): JsonResponse
    {
        $categories = Category::get();

        return $this->success([
            'categories' => $categories
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string',
        ])->validate();

        $category = Category::create($data);

        return $this->success([
            'category' => $category
        ], 201);
    }

    public function update(Request $request, Category $category): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'name' => 'required|string',
        ])->validate();

        $category->update($data);

        return $this->success([
            'category' => $category
        ]);
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return $this->success();
    }
}
