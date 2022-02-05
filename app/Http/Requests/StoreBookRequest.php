<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'title' => ['required', 'string'],
            'author' => ['required', 'string'],
        ];
    }
}
