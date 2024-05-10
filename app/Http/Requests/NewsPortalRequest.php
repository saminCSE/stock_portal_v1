<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsPortalRequest extends FormRequest
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
            'news_category' => [
                'required',
            ],
            'title' => [
                'required',
            ],
            'slug' => [
                'required',
            ],
            'published_date' => [
                'required',
            ],
          
            'short_description' => [
                'required','max:500'
            ],
          
            'long_description' => [
                'required',
            ],
            'source' => [
                'required',
            ],
            'source_link' => [
                'required',
            ],
            'is_published' => [
                'required',
            ],
            'file'=>[
             'mimes:jpeg,png',
            ],
        ];
    }
    public function messages(){
        return [
            'news_category.required' => 'The news category is required.',
            'title.required' => 'The title is required.',
            'slug.required' => 'The slug is required.',
            'published_date.required' => 'Published date is required.',
            'short_description.required' => 'Short description is required.',
            'long_description.required' => 'Long description is required.',
            'is_published.required' => 'The  Status is required.',
            'source_link.required' => 'The  source link is required.',
            'source.required' => 'The  source is required.',
        ];
       
    }
}
