<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MajorRequest extends FormRequest
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
        $major = $this->major;
        return [
            'name' => [
                'required',
                'max:128',
                Rule::unique('majors')->where(function ($q) use ($major) {
                    if ($major) {
                        $q->where('id', '!=', $major);
                    }
                }),
            ]
        ];
    }
}
