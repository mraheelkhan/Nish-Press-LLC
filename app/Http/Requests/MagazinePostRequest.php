<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MagazinePostRequest extends FormRequest
{
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

    public function authorize()
    {
        return true;
    }

}
