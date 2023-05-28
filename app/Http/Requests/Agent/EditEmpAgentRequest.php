<?php

namespace App\Http\Requests\Agent;

use Illuminate\Foundation\Http\FormRequest;

class EditEmpAgentRequest extends FormRequest
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
        ];
    }
}
