<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
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
            'slug' => 'nullable|string|max:350',
            'status' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'keywords' => 'nullable',
            'body' => 'required',
            'image' => 'nullable|mimes:jpeg,bmp,png,gif,svg,webp,jpg',
            'categories' => 'required',
            'author_id' => 'required',
            'h1_hidden' => 'nullable|string|max:255',
            'nav_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:512',
            'canonical' => 'nullable|string|max:255',
            'title_tag' => 'nullable|string|max:255',
            'image_alt' => 'nullable|string|max:255',
            'reading_time' => 'required|string|max:20',
        ];
    }
}
