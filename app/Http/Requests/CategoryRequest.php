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
            'subproperty.*'                => 'required',
            'new_subproperty.*.*'          => 'required',
            'new_property_subproperty.*.*' => 'required',
            'new_property.*'               => 'required',
            'property.*'                   => 'required',
        ];
    }

//    public function withValidator($validator)
//    {
//        $validator->after(function ($validator) {
//            $subProperties = SubProperty::select('sub_properties.*')
//                                        ->join('properties', function ($join) {
//                                            $join->on('properties.id', 'sub_properties.property_id')
//                                                 ->where('properties.category_id', $this->category->id);
//                                        })
//                                        ->get();
//
//            $errorMessage = 'Не може да има 2 податрибута с еднакви имена, които да са към един и същи атрибут';
//
//            foreach ($this->request->get('subproperty') as $key => $item) {
//                foreach ($subProperties as $subProperty) {
//                    if ($key != $subProperty->id && $item == $subProperty->name) {
//                        $validator->errors()
//                                  ->add("subproperty.$subProperty->id", $errorMessage);
//                        $validator->errors()
//                                  ->add("subproperty.$key", $errorMessage);
//                    }
//                }
//
//                foreach ($this->request->get('subproperty') as $key1 => $subProperty) {
//                    if ($key != $key1 && $item == $subProperty) {
//                        $validator->errors()
//                                  ->add("subproperty.$key1", $errorMessage);
//                        $validator->errors()
//                                  ->add("subproperty.$key", $errorMessage);
//                    }
//                }
//            }
//
////                $validator->errors()->add($key, $this->request->get("new_subproperty"));
//            foreach ($this->request->get("new_subproperty") as $key1 => $subProperty) {
//                $validator->errors()->add($key, $key1);
//                if ($key != $key1 && $item == $subProperty) {
//                    $validator->errors()
//                              ->add("subproperty.$key1", $errorMessage);
//                    $validator->errors()
//                              ->add("subproperty.$key", $errorMessage);
//                }
//            }
//        });
//    }

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
