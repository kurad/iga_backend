<?php

namespace App\Http\Requests;

use App\DTO\School\CreateSchoolDto;
use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
            'name' =>'required|string',
            'type' =>'nullable|string',
            'sector_id' => 'required|integer'
        ];

    }

    public function passedValidation()
    {
        $this->dto = new CreateSchoolDto($this->validated());
    }
}