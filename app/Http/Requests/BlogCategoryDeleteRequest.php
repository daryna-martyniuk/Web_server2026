<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogCategoryDeleteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function withValidator($validator)
    {
        $categoryId = $this->route('category');

        $validator->after(function ($validator) use ($categoryId) {

            if (BlogCategory::where('parent_id', $categoryId)->exists()) {
                $validator->errors()->add(
                    'category',
                    'Неможливо видалити категорію, оскільки вона має підкатегорії.'
                );
            }

            if (BlogPost::where('category_id', $categoryId)->exists()) {
                $validator->errors()->add(
                    'category',
                    'Неможливо видалити категорію, до якої прив’язані статті.'
                );
            }
        });
    }

    public function rules(): array
    {
        return [];
    }
}
