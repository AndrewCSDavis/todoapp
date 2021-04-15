<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class Request extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [];
    }

    /**
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData() : array
    {
        if ($this->isJson()) {
            return $this->json()->all();
        }

        return $this->all();
    }
}
