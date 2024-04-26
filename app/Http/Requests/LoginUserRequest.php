<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginUserRequest extends FormRequest
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
            'admin_code'=>['required','integer'],
            'password'=>['required','string','min:6'],
            'token'=>['required', 'string', 'max:255', 'in:'.env('STATIC_TOKEN')],
        ];
    }

    public function messages()
    {
        return [
            'admin_code.required'=>'admin code zorunlu',
            'email.required' => 'eposta alanı zorunlu',
            'email.string' => 'The :attribute field must be a string.',
           'email.max' => 'The :attribute field must not exceed :max characters.',
            // Add custom error messages for each validation rule
        ];
    }
}
