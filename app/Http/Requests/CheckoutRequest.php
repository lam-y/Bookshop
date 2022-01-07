<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
        // بالنسبة لاختبار الايمل عندي حالتين
        // اذا كان المستخدم مسجل دخول بدي اتحقق بس انه ايميل وانه دخله بالفعل
        // اما اذا كان 
        // guest
        // فبدي اتحقق انه ايميل وانه بالفعل دخله وانه مو مسجل فيه عندي من قبل، يعني ما إلو عنا حساب بالـ 
        // users
        // والا بدنا نطلب منه يسجل دخوله

        $emailValidation = auth()->user() ? 'required|email' : 'required|email|unique:users';

        return[
            'email' => $emailValidation,
            'name' => 'required',
            'address' => 'required',
            'country' => 'required',
            'city' => 'required',
            'postalCode' => 'required',
            'phone' => 'required',
        ];
    }

    /**
     * 
     */
    public function messages()
    {
        return[
            'email.unique' => 'You already have an account with this email address. Please <a href="/login">login</a> to continue',
        ];
    }
}
