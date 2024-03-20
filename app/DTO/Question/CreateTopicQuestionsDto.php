<?php

namespace App\DTO\Question;

use App\DTO\InitializeDtoTrait;

class CreateTopicQuestionsDto
{
    use InitializeDtoTrait;


    public string $question;
    public int $topic_id;
}