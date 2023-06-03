<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CourseEditRequest extends FormRequest
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
            'course_name' => 'required',
            'category_id' => 'required',
            'course_level_id' => 'required',
            'course_duration' => 'required',
            'course_fee' => 'required',
            'international_course_fee' => 'required',
            'course_intake' => 'required',
            'awarding_body' => 'required',
            'is_lang_mendatory' => 'required',
        ];
    }
}
