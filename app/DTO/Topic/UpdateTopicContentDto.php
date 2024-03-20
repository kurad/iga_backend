<?php

namespace App\DTO\Topic;

use App\DTO\InitializeDtoTrait;

class UpdateTopicContentDto
{
    use InitializeDtoTrait;


    public string $topic_content;
  
}