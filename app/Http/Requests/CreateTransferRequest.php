<?php

namespace App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {


    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'amount_foregn_currency'       => 'required',
            'amount_local_currency'     => 'required',
            'sender_currency'     => 'required',
            'receiver_currency'     => 'required',
            'amount_foregn_currency'=> 'required',
            'amount_local_currency'=> 'required',
            'amount_rw'=> 'required',
            'charges'=> 'required',
            'currency'=> 'required',
            'local_currency'=> 'required',
            'reception_method'=> 'required',
            'description'=> 'required',
            'names'=>  'required',
            'phone'=> 'required',
            'email'=> 'required',
            'address1'=> 'required',
            'sender_id'=> 'required',
            'receiver_id'=> 'required',
            'balance_before'=> 'required',
            'balance_after_temp'=> 'required',


        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'phone'=> 'required',
            'phone' => str_replace(' ', '',$this->input('phone')),
            'bank_account'=>"none",
            'bank_name'=> "none",
            'unread'=> '1',
            'passcode'=> Str::random(10),
            'user_id'=> Auth::user()->id,
            'class'=> "send",
            'passport'=> "null",

        ]);
    }
}
