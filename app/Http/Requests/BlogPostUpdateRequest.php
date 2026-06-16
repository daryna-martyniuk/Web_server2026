<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogPostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return->auth()->check();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $postId = $this->route('post');

        return [
            'title' => [
                'required',
                'min:5',
                'max:200',
                Rule::unique('blog_posts', 'title')->ignore($postId),
            ],
            'slug' => [
                'nullable',
                'max:200',
                Rule::unique('blog_posts', 'slug')->ignore($postId),
            ],
            'excerpt' => 'max:500',
            'user_id'      => 'required|integer|exists:users,id',
            'content_raw' => 'required|string|min:5|max:10000',
            'content_html' => 'nullable|string|max:10000',
            'category_id' => 'required|integer|exists:blog_categories,id',
        ];
    }
}
