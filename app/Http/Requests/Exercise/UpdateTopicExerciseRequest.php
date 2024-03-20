<?php

namespace App\Http\Requests\Exercise;

use App\DTO\Exercise\UpdateTopicExercisesDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicExerciseRequest extends FormRequest
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
            'exercises' =>'required|string',
        ];
    }

    public function passedValidation()
    {
        $this->dto = new UpdateTopicExercisesDto($this->validated());
    }
}