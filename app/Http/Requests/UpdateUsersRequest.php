<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|' . ($this->user ? "unique:users,email,{$this->user->id}" : "unique:users,email"),
            'mobile' => 'required',
            'gov' => 'required',
            'address' => 'required',
            'role_id' => 'required',
        ];
    }
}
