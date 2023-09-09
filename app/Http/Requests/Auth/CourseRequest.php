<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'description' => 'string|required',
            'difficulty_level' => 'required',
            'duration' => 'integer',
            'image_url' => 'string',
            'new' => 'boolean',
            'free' => 'boolean',
            'language_id' => 'exists:languages,id|required',
            'category_id' => 'exists:categories,id|required',
            'price' => 'required|decimal:0,2'
        ];
    }
}
