<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventsRequest extends FormRequest
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
        return [
            'title.en' => 'required',
            'title.ar' => 'required',
            'description.ar' => 'required',
            'description.en' => 'required',
            'category_name.en' => 'required',
            'category_name.ar' => 'required',
            'date' => 'required',
            'slug' => [
                'required',
                Rule::unique('s_e_o_s')->ignore($this->route()->event->seo->first()->id),
            ]
        ];
    }
}
