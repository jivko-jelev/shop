<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'title' => [
                'required',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('title', $this->request->get('title'))
                                 ->where('parent_id', $this->request->get('parent_id'));
                })->ignore($this->category),],
            'alias' => [
                'required',
                Rule::unique('categories')->where(function ($query) {
                    return $query->where('alias', $this->request->get('alias'));
                })->ignore($this->category),],
        ];
    }

    public function messages()
    {
        return [
            "title.unique" => "Вече съществува такава Категория със същата Главна Категория",
        ];
    }
}
