<?php

namespace App\Http\Requests;

use App\Property;
use App\SubProperty;
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
            'title'                        => [
                'required',
                Rule::unique('categories')
                    ->where(function ($query) {
                        return $query->where('title', $this->request->get('title'))
                                     ->where('parent_id', $this->request->get('parent_id'));
                    })->ignore($this->category),],
            'alias'                        => [
                'required',
                Rule::unique('categories')
                    ->where('alias', $this->request->get('alias'))
                    ->ignore($this->category),],
            'subproperty.*.*'              => 'required',
            'new_subproperty.*.*'          => 'required',
            'new_property_subproperty.*.*' => 'required',
            'new_property.*'               => 'required',
            'property.*'                   => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $errorMessage = 'Не може да има 2 податрибута с еднакви имена, които да са към един и същи атрибут';

            if ($this->request->get("new_subproperty")) {
                foreach ($this->request->get('subproperty') as $key => $property) {
                    foreach ($property as $key1 => $subProperty) {
                        foreach ($property as $key2 => $item) {
                            if ($key1 != $key2 && $item == $subProperty) {
                                $validator->errors()
                                          ->add("subproperty.$key.$key1", $errorMessage);
                            }
                        }
                        if ($this->request->get("new_subproperty")) {
                            foreach ($this->request->get("new_subproperty") as $key5 => $property1) {
                                if ($key == $key5) {
                                    foreach ($property1 as $key3 => $subProperty) {
                                        foreach ($property1 as $key4 => $item1) {
                                            if ($item1 == $subProperty ) {
//                                                $validator->errors()
//                                                          ->add("subproperty.$key.$key1", $errorMessage);
                                                $validator->errors()
                                                          ->add("new_subproperty.$key.$key4", $errorMessage);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

//            if ($this->request->get("new_subproperty")) {
//                foreach ($this->request->get("new_subproperty") as $key => $property) {
//                    foreach ($property as $key1 => $subProperty) {
//                        foreach ($property as $key2 => $item) {
//                            if ($key1 != $key2 && $item == $subProperty) {
//                                $validator->errors()
//                                          ->add("new_subproperty.$key.$key2", $errorMessage);
//                            }
//                        }
//                    }
//                }
//            }
        });
    }

    public function messages()
    {
        return [
            "title.unique"                        => "Вече съществува такава Категория със същата Главна Категория",
            'subproperty.*.required'              => 'Името на податрибута е задължително',
            'new_subproperty.*.required'          => 'Името на податрибута е задължително',
            'new_property_subproperty.*.required' => 'Името на податрибута е задължително',
            'new_property.*.required'             => 'Името на атрибута е задължително',
            'property.*.required'                 => 'Името на атрибута е задължително',
        ];
    }

    public function createProperties($category_id)
    {
        if ($this->get('new_property')) {
            $data = [];
            foreach ($this->get('new_property') as $property) {
                $property = Property::create([
                    'name'        => $property,
                    'category_id' => $category_id,
                ]);

                foreach ($this->get('new_property_subproperty') as $subProperty) {
                    foreach ($subProperty as $newSubproperty) {
                        $data[] = [
                            'name'        => $newSubproperty,
                            'property_id' => $property->id,
                        ];
                    }
                }
            }
            SubProperty::insert($data);
        }
    }
}
