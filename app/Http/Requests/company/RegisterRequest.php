<?php

namespace App\Http\Requests\company;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required','email','unique:companies'],
            'password' => ['required','min:8'],
            'phone' => ['required' , 'numeric'],
            'website' => ['required'],
            'about' => ['required'],
            'service_id' => ['required','exists:services,id'],
        ];
    }
}
