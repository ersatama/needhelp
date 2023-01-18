<?php

namespace App\Http\Requests;

use App\Domain\Contracts\Contract;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Contract::LANGUAGE_ID   =>  'required',
            Contract::REGION_ID =>  'required',
            Contract::NAME  =>  'required',
            Contract::SURNAME   =>  'required',
            Contract::PHONE =>  'required|unique:users,phone,'.$this->{Contract::ID}.',id',
            Contract::EMAIL =>  'nullable|unique:users,email,'.$this->{Contract::ID}.',id',
            Contract::PASSWORD  =>  'required|min:8',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            //
        ];
    }
}
