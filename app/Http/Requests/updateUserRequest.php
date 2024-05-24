<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'username' => 'sometimes|required|string|max:255|unique:users,username,' . $this->route('user'),
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->route('user'),
            'type' => 'sometimes|required|integer',
            'phone' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'avatar' => 'sometimes|nullable|string|max:255',
            'matricule' => 'sometimes|required|string|max:255|unique:users,matricule,' . $this->route('user'),
        ];
    }
}
