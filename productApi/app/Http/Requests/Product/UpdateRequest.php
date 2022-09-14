<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'         =>  'required',
            'category_id'   =>  'required|exists:categories,id',
            'description'   =>  'nullable',
            'price'         =>  'required',
            'image'         =>  'nullable|max:1020|mimes:jpeg,jpg,png',
            'status'        =>  'nullable',
        ];
    }
}
