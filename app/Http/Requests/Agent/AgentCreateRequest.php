<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class AgentCreateRequest extends FormRequest
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
            'agent_name' => 'required',
            'agent_phone' => 'required',
            'agent_email' => 'required',
            'nid_or_passport' => 'required',
            'nationality' => 'required',
            'agent_country' => 'required',
            'agent_state' => 'required',
            'agent_city' => 'required',
            'agent_zip_code' => 'required',
            'agent_address' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6',
        ];
    }
}
