<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class Step1Request extends FormRequest
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
            'applicant_fees_funded' => 'required',
            'current_residential_status' => 'required',
            'campus_id' => 'required',
            'course_id' => 'required',
            'local_course_fee' => 'required',
            'course_program' => 'required',
            'intake' => 'required',
            'course_level' => 'required',
            'delivery_pattern' => 'required',
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required',
            'is_applying_advanced_entry' => 'required',
        ];
    }
}
