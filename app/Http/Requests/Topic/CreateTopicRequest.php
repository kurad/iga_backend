<?php

namespace App\Http\Requests\Topic;

use App\DTO\Topic\CreateTopicDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateTopicRequest extends FormRequest
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
            'topic_title' =>'required|string',
            'instructional_objectives' =>'required|string',
            // 'topic_content' =>'nullable|string',
            'unit_id' => 'required|integer'
        ];
    }

    public function passedValidation()
    {
        $this->dto = new CreateTopicDto($this->validated());
    }
}