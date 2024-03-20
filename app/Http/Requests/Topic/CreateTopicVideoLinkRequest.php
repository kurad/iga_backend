<?php

namespace App\Http\Requests\Topic;

use App\DTO\Topic\UpdateTopicContentDto;
use App\DTO\Topic\UpdateTopicVideoLinkDto;
use Illuminate\Foundation\Http\FormRequest;

class CreateTopicVideoLinkRequest extends FormRequest
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

            'video_link' =>'nullable|string',

        ];
    }

    public function passedValidation()
    {
        $this->dto = new UpdateTopicVideoLinkDto($this->validated());
    }
}