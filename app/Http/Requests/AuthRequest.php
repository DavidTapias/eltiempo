<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email|max:255",
            "password"   => "required|string|min:8"
        ];
    }

    public function messages(): array
    {
        return [

            "email.required" => "El email es obligatorio.",
            "email.email" => "el formato del email noe s válido.",
            "email.max"   => "El email no es válido.",

            "password.required" => "El password es obligatorio.",
            "password.string" => "El password no es válido.",
            "password.max" => "El password no es válido."
        ];
    }
}
