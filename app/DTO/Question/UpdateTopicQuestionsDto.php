<?php

namespace App\DTO\Question;

use App\DTO\InitializeDtoTrait;

class UpdateTopicQuestionsDto
{
    use InitializeDtoTrait;


    public string $question;
    public int $topic_id;
}