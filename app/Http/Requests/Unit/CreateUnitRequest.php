<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Unit\CreateUnitDto;

class CreateUnitRequest extends FormRequest
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
            'unit_title' =>'required|string',
            'key_unit_competence' =>'nullable|string',
            'subject_id' => 'required|integer'
        ];

    }

    public function passedValidation()
    {
        $this->dto = new CreateUnitDto($this->validated());
    }
}