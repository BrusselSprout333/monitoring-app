<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255|min:2|regex:#^[a-zA-Z -]+$#',
            'job'    => 'required|string|max:255|min:2|regex:#^[a-zA-Z -]+$#',
        ];
    }

    public function getName(): string
    {
        return $this->input('name');
    }

    public function getJob(): string
    {
        return $this->input('job');
    }
}
