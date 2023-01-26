<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $student = $this->student;

        return [
            'name' => 'required|max:128',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($q) use ($student) {
                    if ($student) {
                        $q->where('uuid', '!=', $student);
                    }
                }),
            ],
            'password' => [
                'min:8', 'max:16', 'regex:/^[A-Za-z0-9]*$/', 'same:password_old', 'nullable'
            ],
            'password_old' => 'nullable',

            'phone' => [
                'max:24',
                'required',
                'regex:/^(0(\d-\d{4}-\d{4}))|(0(\d{3}-\d{2}-\d{4}))|((070|080|090|050)(-\d{4}-\d{4}))|(0(\d{2}-\d{3}-\d{4}))|(0(\d{9,10}))+$/',
                Rule::unique('users')->where(function ($q) use ($student) {
                    if ($student) {
                        $q->where('uuid', '!=', $student);
                    }
                }),
            ],
            'major' => 'required',
            'course' => 'required',
            'birthday' => 'required',
            'gender' => 'required',
            'address' => 'nullable|max:1024',
        ];
    }
}
