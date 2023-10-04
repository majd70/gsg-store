<?php

namespace App\Http\Requests;

use App\Rules\filter;
use Illuminate\Foundation\Http\FormRequest;

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
            //
            'name' => [ //make custom rule by function
                'required',
                'string',
                'max:255',
                'min:3',
                'unique:categories,name',
                function ($attribute, $value, $fail) {
                    if (stripos($value, 'messi') !== false) {
                        $fail('fuck messi bitch');
                    }
                },

            ],
            'parent_id' => 'nullable|int|exists:categories,id',
            'description' => [//make custom role by  rule class
                'min:5',
                new filter(['fuck','bitch','son of a bitch'])
            ],
            'status' => 'required|in:active,draft',
            'image' => 'nullable|image|max:512000|dimensions:min_width=300,min_height=300',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الرجاء ادخال اسم',

        ];
    }
}
