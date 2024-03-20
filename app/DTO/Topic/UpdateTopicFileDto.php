<?php

namespace App\DTO\Topic;

use App\DTO\InitializeDtoTrait;

class UpdateTopicFileDto
{
    use InitializeDtoTrait;


    public string $file_name;
  
}