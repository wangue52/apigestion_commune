<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class userRequest extends FormRequest
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
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8', // Enforce minimum password length
            'type' => 'required|in:agent,receveur,renovations',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image', // Validate for image format
            'matricule' => 'nullable|string|max:255',
        ];
    }
}
