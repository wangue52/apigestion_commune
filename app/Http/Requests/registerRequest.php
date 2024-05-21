<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class registerRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'matricule' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'password' => Hash::make($this->password),
        ]);
    }
}

