<?php

namespace App\Http\Requests\Lesson;

use App\DTO\Lesson\CreateLessonDto;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
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
            'lesson_title' =>'required|string',
            'instructional_objective' =>'nullable|string',
            'unit_id' => 'required|integer'
        ];
    }
    public function passedValidation()
    {
        $this->dto = new CreateLessonDto($this->validated());
    }
}