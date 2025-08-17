<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'gender'     => ['required','in:male,female'],
            'phone'        => ['string'],
            'email' => ['nullable','email','max:150'],
            'address' => ['nullable','string','max:255'],
            'status'  => ['required','in:active,on_hold,withdrawn'],
        ];
    }
}
