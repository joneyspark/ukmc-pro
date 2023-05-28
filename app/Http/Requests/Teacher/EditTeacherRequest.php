<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Foundation\Http\FormRequest;

class EditTeacherRequest extends FormRequest
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
            'campus_id' => 'required',
            'teacher_name' => 'required',
            'teacher_phone' => 'required',
            'teacher_email' => 'required',
            'teacher_alternative_contact' => 'required',
            'teacher_nid_or_passport' => 'required',
            'nationality' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'name' => 'required',
        ];
    }
}
