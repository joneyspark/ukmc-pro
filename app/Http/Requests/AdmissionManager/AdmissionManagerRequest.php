<?php

namespace App\Http\Requests\AdmissionManager;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionManagerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'manager_id' => 'required',
            'officer_name' => 'required',
            'officer_phone' => 'required',
            'officer_email' => 'required',
            'officer_alternative_contact' => 'required',
            'officer_nid_or_passport' => 'required',
            'nationality' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'photo' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ];
    }
}
