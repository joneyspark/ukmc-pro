<?php

namespace App\Http\Requests\Campus;

use Illuminate\Foundation\Http\FormRequest;

class CampusRequest extends FormRequest
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
            'country' => 'required',
            'campus_name' => 'required',
            'monthly_living_cost' => 'required',
            'funds_requirements_for_visa' => 'required',
            'application_fee' => 'required',
            'currency' => 'required',
            'is_lang_mendatory' => 'required',
            'lang_requirements' => 'required',
            'institute_benifits' => 'required',
            'per_time_work_details' => 'required',
            'scholarship_policy' => 'required',
            'institute_important_notes' => 'required',
            'institute_logo' => 'required',
        ];
    }
}
