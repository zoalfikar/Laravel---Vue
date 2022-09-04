<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\Nullable;

class StoreSurveyRequest extends FormRequest
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
    protected function prepearForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id
        ]);

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'user_id' => 'exists:user,id',
            'image' => 'nullable|string',
            'title' => 'required|string|max:1000',
            'status' => 'required|boolean',
            'description' => 'nullable|string',
            'expire_date' => 'nullable|date|after:tomorrow'
        ];
    }
}
