<?php

namespace App\Http\Requests\Postamat;

use Illuminate\Foundation\Http\FormRequest;

class DefectiveStoreRequest extends FormRequest
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
            'title'     => 'required|max:50',
            'description'       => 'required|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'title is required',
            'description.required' => 'description is required',
            'title.max' => 'title must be less than 50 characters',
            'description.max' => 'description must be less than 255 characters',
        ];
    }
}
