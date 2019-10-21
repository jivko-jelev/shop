<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'title'       => 'required',
            'category'    => 'required',
            'price'       => 'required|numeric|min:0.01',
            'promo_price' => 'nullable|numeric|max:' . ($this->price - 0.01),
        ];
    }

    public function messages()
    {
        return [
            'promo_price.min' => 'Промо цената трябва да бъде по-малка от цената на продукта'
        ];
    }
}
