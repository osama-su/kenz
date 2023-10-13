<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePortfoliosRequest extends FormRequest
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
            'description.en' => 'required',
            'description.ar' => 'required',
            'service_id' => 'required',
            'slug' => [
                'required',
                Rule::unique('s_e_o_s')->ignore($this->route()->portfolio->seo->first()->id),
            ]
        ];
    }
}
