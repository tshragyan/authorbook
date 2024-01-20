<?php

namespace App\Http\Requests;

use App\Rules\ArrayItemsMustBeInArray;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
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
            'title' => 'required|string|max:256',
            'genre' => 'required|string|max:256',
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id'
        ];
    }
}
