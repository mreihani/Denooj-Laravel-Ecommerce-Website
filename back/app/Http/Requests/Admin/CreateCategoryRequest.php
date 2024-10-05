<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:280',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,webp',
            'seo_title' => 'nullable|string|max:255',
            'index' => 'integer|min:0',
            'home_section_title' => 'nullable|required_if:display_in_home,on|string|max:255',
            'section_subtitle' => 'nullable|string|max:255',
            'parent_id',
            'featured',
            'display_in_home',
            'seo_description',
            'meta_description',
        ];
    }
}
