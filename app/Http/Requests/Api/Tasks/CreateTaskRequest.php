<?php

namespace App\Http\Requests\Api\Tasks;

use App\Http\Requests\Api\ApiRequest;

class CreateTaskRequest extends ApiRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:65535'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
