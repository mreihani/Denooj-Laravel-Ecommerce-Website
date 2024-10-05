<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'author_id' => 'required',
            'sku' => 'nullable|string|max:255|unique:products,sku,'.$this->product->id,
            'title' => 'required|string|max:255',
            'title_latin' => 'nullable|string|max:255',
            'torob_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:355',
            'short_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg,webp|max:8000',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:8000',
            'body',
            'stock' => 'nullable|integer|min:0',
            'stock_status' => 'required',
            'price' => 'required|integer|min:0',
            'extra_shipping_cost' => 'nullable|integer|min:0',
            'weight' => 'nullable|integer|min:1',
            'shipping_time' => 'nullable|string|max:255',
            'sale_price' => [
                'nullable',
                'integer',
                'min:0',
                request()->filled('price') && request('price') > 0 ? 'lt:price' : ''
            ],
            'status' => 'required',
            'categories' => 'required',
            'h1_hidden' => 'nullable|string|max:255',
            'nav_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:512',
            'canonical' => 'nullable|string|max:255',
            'title_tag' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
        ];
    }
}
