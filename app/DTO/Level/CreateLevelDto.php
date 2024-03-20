<?php

namespace App\DTO\Level;

use App\DTO\InitializeDtoTrait;

class CreateLevelDto
{
    use InitializeDtoTrait;


    public string $name;
}