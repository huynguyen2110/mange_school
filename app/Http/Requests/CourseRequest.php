<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $course = $this->course;
        return [
            'name' => [
                'required',
                'max:128',
                Rule::unique('courses')->where(function ($q) use ($course) {
                    if ($course) {
                        $q->where('id', '!=', $course);
                    }
                }),
            ]
        ];
    }
}
