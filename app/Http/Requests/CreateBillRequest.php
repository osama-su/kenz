<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBillRequest extends FormRequest
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
            'product_id' => 'required',
            'company_id' => 'required',
            'supplier_id' => 'required',
            'qty' => 'required',
            'color' => 'required',
            'model' => 'required',
            'size' => 'required',
            'price' => 'required',
            'gov' => 'required',
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'address' => 'required',
        ];
    }
}
