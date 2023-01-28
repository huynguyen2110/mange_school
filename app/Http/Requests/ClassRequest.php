<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassRequest extends FormRequest
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
        $class = $this->class;
        return [
            'name' => [
                'required',
                'max:128',
                Rule::unique('classes')->where(function ($q) use ($class) {
                    if ($class) {
                        $q->where('id', '!=', $class);
                    }
                }),
            ],
            'subject_id' => 'required',
            'teacher_id' => 'required',
        ];
    }
}
