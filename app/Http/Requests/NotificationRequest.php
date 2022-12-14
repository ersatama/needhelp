<?php

namespace App\Http\Requests;

use App\Domain\Contracts\Contract;
use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        if (backpack_user()->{Contract::ROLE} === Contract::LAWYER) {
            return [
                Contract::ANSWER    =>  'required|min:8',
                Contract::ANSWERED_AT   =>  'nullable',
                Contract::LAWYER_ID =>  'nullable|exists:users,id',
                Contract::STATUS    =>  'nullable'
            ];
        }
        return [
            Contract::USER_ID   =>  'required|exists:users,id',
            Contract::DESCRIPTION   =>  'required',
            Contract::ANSWERED_AT   =>  'nullable',
            Contract::LAWYER_ID =>  'nullable|exists:users,id',
            Contract::STATUS    =>  'nullable'
            // 'name' => 'required|min:5|max:255'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
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
    public function messages()
    {
        return [
            //
        ];
    }
}
