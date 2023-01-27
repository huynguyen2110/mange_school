<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
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
        $teacher = $this->teacher;

        return [
            'name' => 'required|max:128',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($q) use ($teacher) {
                    if ($teacher) {
                        $q->where('uuid', '!=', $teacher);
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
                Rule::unique('users')->where(function ($q) use ($teacher) {
                    if ($teacher) {
                        $q->where('uuid', '!=', $teacher);
                    }
                }),
            ],
            'major_id' => 'required',
            'birthday' => 'required|before_or_equal:now',
            'gender' => 'required',
            'address' => 'nullable|max:1024',
        ];
    }
}
