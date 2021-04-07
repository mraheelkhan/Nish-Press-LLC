<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagazineUpdateRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'required',
            'cover_image' => 'required|mimes:jpeg,jpg,png,gif',
            'pdf_filename' => 'required|mimes:pdf|max:8448',
            'price' => 'nullable|numeric'
        ];
    }
}
