<?php

namespace App\Http\Requests\Question;

use App\DTO\Question\UpdateTopicQuestionsDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicQuestionRequest extends FormRequest
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
            'question' =>'nullable|string',
            'topic_id' => 'required|integer'
        ];
    }

    public function passedValidation()
    {
        $this->dto = new UpdateTopicQuestionsDto($this->validated());
    }
}