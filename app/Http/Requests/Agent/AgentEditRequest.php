<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class AgentEditRequest extends FormRequest
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
            'company_name' => 'required',
            'company_registration_number' => 'required',
            'company_establish_date' => 'required',
            'company_trade_license_number' => 'required',
            'company_email' => 'required',
            'company_phone' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'address' => 'required',
            'agreement_title' => 'required',
            'agreement_expire_date' => 'required',
        ];
    }
}
