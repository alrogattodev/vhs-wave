<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'availability' => 'boolean',
            'price' => 'required|numeric|min:0',
        ];
    }
}

