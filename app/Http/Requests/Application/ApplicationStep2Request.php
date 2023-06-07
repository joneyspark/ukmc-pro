<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStep2Request extends FormRequest
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
            'nationality' => 'required',
            'ethnic_origin' => 'required',
            'country' => 'required',
            'highest_qualification' => 'required',
            'last_institution_you_attended' => 'required',
            'unique_learner_number' => 'required',
            'name_of_qualification' => 'required',
            'you_obtained' => 'required',
            'subject' => 'required',
            'grade' => 'required',
            'house_number' => 'required',
            'address_line_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'address_country' => 'required',
        ];
    }
}
