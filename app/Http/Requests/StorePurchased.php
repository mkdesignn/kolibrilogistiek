<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePurchased extends FormRequest
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
            'customer_id'=>Auth::user()->isAdmin() ? 'required' : '',
            'supplier_id'=>'required',
            'expected_at'=>'required|date',
            'number'=>'required',
            'trackandtrace'=>'required',
            'quantity' => 'required|array',
            'product'=>'required|array',
            'batch'=>'array',
            'expire_date'=>'array',
            'expire_date.*'=>'date'
        ];
    }
}
