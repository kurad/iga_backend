<?php

namespace App\DTO\Exercise;

use App\DTO\InitializeDtoTrait;

class CreateTopicExercisesDto
{
    use InitializeDtoTrait;


    public string $exercises;
    public int $topic_id;
}