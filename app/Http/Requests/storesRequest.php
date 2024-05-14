<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storesRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'number' => $this->generateMatricule(),
            'bloc_id' => 'required|integer|exists:blocs,id',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'status' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Please fill the name.',
            'bloc.required' => 'Please fill the required.',
            'bloc_id.required' => 'Please fill the bloc_id.',
            'district.required' => 'Please fill the district.',
        ];
    }
}
